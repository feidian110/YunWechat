<?php


namespace addons\YunWechat\html5\controllers;


use addons\YunWechat\common\models\account\Bind;
use addons\YunWechat\common\models\base\DemoData;
use common\helpers\WechatHelper;
use EasyWeChat\Kernel\Messages\Text;
use Yii;
use yii\web\NotFoundHttpException;

class AuthController extends BaseController
{
    public $enableCsrfValidation = false;


    /**
     * 公众号授权事件消息接收
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \ReflectionException
     */
    public function actionEvent()
    {
        $request = Yii::$app->request;
        switch ($request->getMethod()) {

            case 'GET':
                throw new NotFoundHttpException('签名验证失败.');
                break;
            // 接收数据
            case 'POST':
                $openPlatform = Yii::$app->wechat->getOpenPlatform();
                $server = $openPlatform->server;
                // 处理授权成功事件
                $server->push(function ($message) {
                    switch ($message['InfoType']) {
                        //推送ticket
                        case 'component_verify_ticket':
                            break;
                        //授权成功事件
                        case 'authorized':
                            break;
                        //授权更新事件
                        case  'updateauthorized':
                            break;
                        //授权取消事件
                        case 'unauthorized':
                            break;
                        default:
                            return 'fail';
                            break;
                    }
                });

                $response = $openPlatform->server->serve();
                $response->send();
                break;
            default:
                throw new NotFoundHttpException('所请求的页面不存在.');
        }
        exit();
    }

    public function actionMsg()
    {
        $request = Yii::$app->request;

        switch ($request->getMethod()) {
            // 激活公众号
            case 'GET':
                if (WechatHelper::verifyToken($request->get('signature'), $request->get('timestamp'),
                    $request->get('nonce'))) {
                    return $request->get('echostr');
                }

                throw new NotFoundHttpException('签名验证失败.');
                break;
            // 接收数据
            case 'POST':
                $appid = substr($request->get('appid'),1);
                $app =Bind::findOne(['appid'=>$appid]);
                $openPlatform = Yii::$app->wechat->getOpenPlatform();
                $account = $openPlatform->officialAccount((string)$app['appid'], (string)$app['refresh_token']);
                $account->server->push(function ($message ) use ($app,$openPlatform) {

                    try {
                        // 微信消息
                        Yii::$app->yunWechatService->message->setMessage($message);// 消息记录
                        Yii::$app->params['msgHistory'] = [
                            'openid' => $message['FromUserName'],
                            'type' => $message['MsgType'],
                            'event' => '',
                            'rule_id' => 0, // 规则id
                            'keyword_id' => 0, // 关键字id
                        ];

                        if( $message['ToUserName'] =='gh_3c884a361561' ){
                            return $this->release($app,$openPlatform);
                        }else{
                            switch ($message['MsgType']) {
                                case 'event' : // '收到事件消息';
                                    $reply = $this->event($message);
                                    break;
                                case 'text' : //  '收到文字消息';
                                    $reply = Yii::$app->yunWechatService->message->text();
                                    break;
                                default : // ... 其它消息(image、voice、video、location、link、file ...)
                                    $reply = Yii::$app->yunWechatService->message->other();
                                    break;
                            }
                            Yii::$app->yunWechatService->msgHistory->save(Yii::$app->params['msgHistory'],
                                Yii::$app->yunWechatService->message->getMessage());

                            return $reply;
                        }


                    } catch (\Exception $e) {
                        // 记录行为日志
                        Yii::$app->services->log->setErrorStatus(500, 'wechatApiReply', $e->getMessage());
                        Yii::$app->services->log->push();

                        if (YII_DEBUG) {
                            return $e->getMessage();
                        }

                        return '系统出错，请联系管理员';
                    }
                });

                // 将响应输出
                $response = $account->server->serve();
                $response->send();
                break;
            default:
                throw new NotFoundHttpException('所请求的页面不存在.');
        }

        exit();
    }

    protected function event($message)
    {
        Yii::$app->params['msgHistory']['event'] = $message['Event'];

        switch ($message['Event']) {
            // 关注事件
            case 'subscribe' :
                Yii::$app->yunWechatService->fans->follow($message['FromUserName']);
                // 判断是否是二维码关注
                if ($qrResult = Yii::$app->yunWechatService->qrcodeStat->scan($message)) {
                    $message['Content'] = $qrResult;
                    Yii::$app->yunWechatService->message->setMessage($message);
                    return Yii::$app->yunWechatService->message->text();
                }

                return Yii::$app->yunWechatService->message->follow() ? Yii::$app->yunWechatService->message->follow() : "欢迎关注，我们将竭诚为您服务！";
                break;
            // 取消关注事件
            case 'unsubscribe' :
                Yii::$app->yunWechatService->fans->unFollow($message['FromUserName']);

                return false;
                break;
            // 二维码扫描事件
            case 'SCAN' :
                if ($qrResult = Yii::$app->yunWechatService->qrcodeStat->scan($message)) {
                    $message['Content'] = $qrResult;
                    Yii::$app->yunWechatService->message->setMessage($message);

                    return Yii::$app->yunWechatService->message->text();
                }
                break;
            // 上报地理位置事件
            case 'LOCATION' :

                //TODO 暂时不处理

                break;
            // 自定义菜单(点击)事件
            case 'CLICK' :
                $message['Content'] = $message['EventKey'];
                Yii::$app->yunWechatService->message->setMessage($message);

                return Yii::$app->yunWechatService->message->text();
                break;
        }

        return false;
    }

    protected function release($app,$openPlatform)
    {
        $message = $openPlatform->server->getMessage();
        //返回API文本消息
        if ($message['MsgType'] == 'text' && strpos($message['Content'], "QUERY_AUTH_CODE:") !== false) {
            $auth_code = str_replace("QUERY_AUTH_CODE:", "", $message['Content']);
            $authorization = $openPlatform->handleAuthorize($auth_code);
            $official_account_client = $openPlatform->officialAccount($app['appid'], $authorization['authorization_info']['authorizer_refresh_token']);
            $content = $auth_code . '_from_api';
            $official_account_client['customer_service']->send([
                'touser' => $message['FromUserName'],
                'msgtype' => 'text',
                'text' => [
                    'content' => $content
                ]
            ]);

            //返回普通文本消息
        } elseif ($message['MsgType'] == 'text' && $message['Content'] == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
            $official_account_client = $openPlatform->officialAccount($app['appid']);
            $official_account_client->server->push(function ($message) {
                return $message['Content'] . "_callback";
            });
            //发送事件消息
        } elseif ($message['MsgType'] == 'event') {
            $official_account_client = $openPlatform->officialAccount($app['appid']);
            $official_account_client->server->push(function ($message) {
                return $message['Event'] . 'from_callback';
            });
        }
        $response = $official_account_client->server->serve();
        return $response;
    }
}
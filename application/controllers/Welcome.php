<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once './vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Welcome extends CI_Controller
{
    public function index()
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $channel->exchange_declare('my_app', 'direct', false, false, false);

        $data = "Hi, i just sent msg !";
        $msg = new \PhpAmqpLib\Message\AMQPMessage(
            json_encode(array('userId'=>'22', 'msg'=>'success')),
            array(
                    'delivery_mode' => 2,
                    'content_type' => 'application/json',
                )
        );

        $channel->basic_publish($msg, 'my_app', 'user777');
        echo " [x] Sent 'Hello World!'\n";
        $channel->close();
        $connection->close();
        $this->load->view('welcome_message');
    }
}

<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/fontawesome/all.css',
        'css/rating.css',
        'css/main.css',
        'css/index.css',
        'css/events.css',
        'css/shop.css',
        'css/tasks.css',
        'css/event.css',
        'css/userdata.css',
        'css/login.css',
        'css/order-list.css',
        'css/product-list.css',
        'css/order-list.css',
        'css/new.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

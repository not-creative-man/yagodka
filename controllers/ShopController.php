<?php

namespace app\controllers;

use app\models\Cash;
use app\models\Order;
use app\models\Product;
use app\models\ProductForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class ShopController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect(['/site/index']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreateOrder($product_id) {
        $user_id = Yii::$app->user->id;
        $product = Product::findOne(['id' => $product_id]);

        $cash = Cash::findAll(["user_id" => $user_id]);
        $user_cash = 0;
        foreach ($cash as $record) {
            $user_cash += $record->count;
        }

        if ($user_cash < $product->cost) {
            echo "Недостаточно ягодок :(";
            die;
        }

        $new_order = new Order();
        $new_order->user_id = $user_id;
        $new_order->product_id = $product_id;
        $new_order->status = Order::NEED_ATTENDANCE;
        $new_order->save();

        $record = new Cash();
        $record->user_id = $user_id;
        $record->comment = "Покупка {$product->name}";
        $record->count = $product->cost * -1;
        $record->service = 2000000 + $new_order->id;
        $record->save();

        return $this->redirect(['shop/shop']);
    }

    public function actionOrderList() {
//        $active_orders = Order::find()->where(['status' => Order::NEED_ATTENDANCE])->all();
//        $complete_orders = Order::find()->where(['status' => Order::COMPLETE])->all();
        $orders = Order::find();
        return $this->render('order-list',
            [
                'orders' => $orders,
            ]
        );
    }

    public function actionShop() {
        $product = Product::find()->where(['active' => 1])->all();

        return $this->render('shop',
            [
                'product' => $product,
            ]
        );
    }

    public function actionCompleteOrder($order_id) {
        $order  = Order::findOne(["id" => $order_id]);
        $order->status = Order::COMPLETE;
        $order->save();

        return $this->redirect(["shop/order-list"]);
    }

    public function actionDeleteOrder($order_id) {
        $order = Order::findOne(["id" => $order_id]);
        $cash_record = Cash::findOne(["service" => 2000000 + $order_id]);
        if ($order && $cash_record) {
            if ($order->delete()) $cash_record->delete();
        }

        return $this->redirect(["shop/order-list"]);
    }

    public function actionProductList() {
        $product_list = Product::find()->where(['<>', 'id', -1])->all();

        return $this->render('product-list',
            [
                'product_list' => $product_list,
            ]
        );
    }

    public function actionDisableProduct($product_id) {
        $product = Product::findOne(["id" => $product_id]);
        $product->active = 0;
        $product->save();

        return $this->redirect(["shop/product-list"]);
    }

    public function actionEnableProduct($product_id) {
        $product = Product::findOne(["id" => $product_id]);
        $product->active = 1;
        $product->save();

        return $this->redirect(["shop/product-list"]);
    }

    public function actionCreateProduct() {
        $product_form = new ProductForm();

        if (Yii::$app->request->isPost) {
            if ($product_form->load(Yii::$app->request->post())){
                $product_form->image = UploadedFile::getInstance($product_form, 'image');
                if ($product_form->create()) return $this->redirect(['shop/product-list']);
            }
        }

        return $this->render('create-product', [
            'product_form' => $product_form,
            'bottom_text' => 'Создать',
            'title_text' => 'Новый товар'
        ]);
    }

    public function actionUpdateProduct($product_id) {
        $product = Product::findOne($product_id);
        $product_form = new ProductForm();

        foreach ($product->attributes as $key => $value) {
            if (in_array($key, ['image', 'id'])) continue;
            $product_form->$key = $value;
        }

        if (Yii::$app->request->isPost) {
            if ($product_form->load(Yii::$app->request->post())){
                $product_form->image = UploadedFile::getInstance($product_form, 'image');
                if ($product_form->update($product_id)) return $this->redirect(['shop/product-list']);
            }
        }

        return $this->render('create-product', [
            'product_form' => $product_form,
            'bottom_text' => 'Изменить',
            'title_text' => 'Изменить товар'
        ]);
    }
}
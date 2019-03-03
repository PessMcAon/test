<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 11/28/2017
 * Time: 8:04 PM
 */

namespace app\controllers;

use app\models\ProcessProgressFile;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;


class UploadController extends Controller
{
    public function actionUpload($contact){
        $model = new ProcessProgressFile();

        if(isset($_POST['Upload']))
        {
            $model->attributes = $_POST['Upload'];
            $file = CUploadedFile::getInstance($model,'file');
            $new_name = time().'_' . $file->getName(); // newname คือชื่อใหม่ เปลี่ยนเป็นชื่ออะไรก็ได้ (อย่าลืม มีจุดต่อท้ายด้วย)
            $model->file = $new_name; // บันทึกชื่อไฟล์ใหม่ที่กำหนด เก็บไว้ใน model
            if($model->validate()){
                $uploaded = $file->saveAs($dir.'/'.$file->getName());
                $fileName = $file->getName();
            }

            if($model->save())     //เก็บข้อมูลลง Database
                $this->redirect(array('view','id'=>$model->id));

        }
        echo $contact;
    }
}
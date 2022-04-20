<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="uk-container uk-container-center">
    <div class="uk-grid">
        <div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
            <?php $this->load->view('student/menu'); ?>
        </div>
        <div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <div class="uk-text-center">
                <h2>ขอฝึกอาชีพในสถานประกอบการ</h2>
            </div>
            <hr>

            <div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                <h3 class="uk-panel-title">คำร้องขอฝึกอาชีพในสถานประกอบการ</h3>
                <?php
                if (empty($data->student)) {
                ?>
                    <div class="uk-alert uk-alert-danger uk-text-center">
                        <a href="<?= site_url('settings/profile') ?>" class="uk-text-danger">
                            กรุณากรอกข้อมูลให้ครบถ้วน ก่อนดำเนินการต่างๆต่อไป
                            <br>...คลิก...
                        </a>
                    </div>
                <?php
                } else {
                ?>
                    <form method="post">
                        <dl class="uk-description-list-horizontal">
                            <dt>ชื่อ-นามสกุล</dt>
                            <dd><?= $data->student->firstname.' '.$data->student->lastname ?></dd>
                            <dt>รหัสประจำตัวนักศึกษา</dt>
                            <dd><?= $data->student->student_id ?></dd>
                            <dt>ช่วงเวลาที่ฝึกงาน</dt>
                            <dd><?= $data->internship->title.'<br>'.$data->internship->internship_start.' ถึง '.$data->internship->internship_end ?></dd>
                            <dt>สถานที่ฝึกงาน</dt>
                            <dd><?= $data->company->name ?></dd>
                        </dl>
                        <div class="uk-text-center">
                            <button type="submit" name="submit" class="uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top">ส่งคำร้องขอผึกอาชีพ</button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
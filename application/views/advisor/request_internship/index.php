<div class="uk-container uk-container-center">
    <div class="uk-grid">
        <div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
            <?php echo $leftmenu; ?>
        </div>
        <div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <div class="uk-text-center">
                <h2>สรุปผลการฝึกงานในสถานประกอบการ</h2>
                <h3>(สำหรับครูนิเทศการฝึกงาน)</h3>
            </div>
            <hr>
            
            <table class="uk-table uk-table-border">
                <thead>
                    <tr>
                        <th class="uk-text-center">ลำดับที่</th>
                        <th>ชื่อนักศึกษา</th>
                        <th class="uk-text-center">การอนุมัติ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $i => $std) ?>
                    <tr>
                        <td class="uk-text-center"><?= $i+1 ?></td>
                        <td><?= $std->firstname.' '.$std->lastname ?></td>
                        <td class="uk-text-center">
                            <?php if($std->supervisor === '0') { ?>
                                <a href="<?= site_url('advisor/request_internship/approve?s=1&std='.$std->user_id) ?>" class="uk-button uk-button-mini uk-button-success">อนุมัติ</a>
                            <?php } elseif($std->supervisor === '1') { ?>
                                <div class="uk-button uk-button-mini uk-button-primary">อนุมัติแล้ว</div>
                            <?php } ?>
                    </tr>
                </tbody>
            </table>

            
        </div>
    </div>
</div>
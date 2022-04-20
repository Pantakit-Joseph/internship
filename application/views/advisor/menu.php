<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('advisor');?>">
		<a href="<?php echo base_url('advisor'); ?>"><span class="uk-icon-home"></span> หน้าหลัก</a>
	</li>
	<!-- 
	<li class="<?php echo $this->helper_lib->getActiveMenu('activity');?>">
		<a href="<?php echo base_url('advisor/activity'); ?>"><span class="uk-icon-book"></span> บันทึกการเรียน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('time');?>">
		<a href="<?php echo base_url('advisor/time'); ?>"><span class="uk-icon-clock-o"></span> บันทึกเวลาเรียน</a>
	</li>
	 -->
	<li class="<?php echo $this->helper_lib->getActiveMenu('evaluation');?>">
		<a href="<?php echo base_url('advisor/evaluation'); ?>"><span class="uk-icon-pie-chart"></span> ประเมินผลการฝึกงาน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('request_internship');?>">
		<a href="<?php echo base_url('advisor/request_internship/'); ?>"><span class="uk-icon-cube"></span> อนุมัติขอฝึกงาน</a>
	</li>
	<br/><br/>
</ul>
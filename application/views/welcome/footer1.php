<div class="footer">
				<div class="row">
					<div class="menu-footer">
						<ul>
							<li><a href="/welcome/privacy"><?php echo $this->lang->line('head_3');?></a></li>
							<li><a href="/welcome/term"><?php echo $this->lang->line('head_4');?></a></li>
							<li><a href="/welcome/faq">FAQ</a></li>
							<li><a href="/welcome/contacts"><?php echo $this->lang->line('supp_page');?></a></li>
						</ul>
					</div>
					<div class="lang">
						<div class="lang-btn-footer">
							<img src="/assets/images/<?php if(get_cookie('lang') == NULL || get_cookie('lang') == 'english') { ?>en<?php }elseif(get_cookie('lang') == 'german'){ ?>de<?php }else{ ?>rus<?php } ?>.png" >
							Русский
						</div>
						<div class="lang-all-footer">
							<a onclick="document.location.href='<?php echo base_url();?>index.php/user/switch_lang/russian'"><img src="/assets/images/rus.png" align="center">
							Русский</a>
							<br>
							<a onclick="document.location.href='<?php echo base_url();?>index.php/user/switch_lang/english'"><img src="/assets/images/en.png" align="center">
							English</a>
							<br>
							<a onclick="document.location.href='<?php echo base_url();?>index.php/user/switch_lang/german'"><img src="/assets/images/de.png" align="center">
							German</a>
						</div>
						<script>
							$('.lang-btn-footer').click(function(){
								$(".lang-all-footer").slideToggle(400);
							});
						</script>
					</div>
					<div style="clear:both;"></div>
					<div class="copyright">
						 Copyrighted © Premium Rush 2019. All rights reserved.
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
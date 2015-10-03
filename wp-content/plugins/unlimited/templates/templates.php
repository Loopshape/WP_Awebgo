<script type="text/template" id="pb-un-form-tmpl">	
	<form class="pb-un-form pb-inline" id="<%= form_id %>">
		<div class="pb-inline">	
			<% if(theme) {%>
			<fieldset class="pb-un-field-row pb-clr pb-un-notice">
				<legend><?php _e('Theme', 'unlimited'); ?></legend>
				<span class="pb-un-label"><?php _e('Theme', 'unlimited'); ?>:</span>
				<div class="pb-un-input-wrapper">
					<input value="<%= theme %>" name="theme" disabled/>
				</div></br>	
				<p><b><?php _e('Theme match found', 'unlimited'); ?>.</b></br><?php _e('Please only change the css selectors if you\'ve altered this theme', 'unlimited'); ?>.</p>
			</fieldset>
			<% } %>
			<fieldset class="pb-un-form-section">
				<legend><?php _e('Type', 'unlimited'); ?></legend>
				<div class="pb-un-types">
					<label><input type="radio" name="untype" value="scroll" class="pb-un-chose-type" <%- untype === 'scroll' ? 'checked' : '' %>/><h4><?php _e('On scroll', 'unlimited'); ?></h4></label>
						<div class="pb-un-chosen-type pb-hidden">
							<div class="pb-un-field-row pb-clr"><label>
								<span class="pb-un-label"><?php _e('Threshold', 'unlimited'); ?>:</span>
								<div class="pb-un-input-wrapper">
									<input value="<%= threshold %>" name="threshold"/>
									<span><?php _e('Distance to bottom', 'unlimited'); ?></span>
								</div>	
							</label></div>	
						</div>
					<label><input type="radio" name="untype" value="load" class="pb-un-chose-type" <%- untype === 'load' ? 'checked' : '' %>/><h4><?php _e('Load more button', 'unlimited'); ?></h4></label>
						<div class="pb-un-chosen-type pb-hidden">
							<div class="pb-un-field-row pb-clr"><label>
								<span class="pb-un-label"><?php _e('Button Text', 'unlimited'); ?></span>
								<div class="pb-un-input-wrapper">
									<input value="<%= load_more_text %>" name="load_more_text"/>
								</div>	
							</label></div>
							<div class="pb-un-field-row pb-clr"><label>
								<span class="pb-un-label"><?php _e('Loading', 'unlimited'); ?></span>
									<div class="pb-un-input-wrapper">
										<input value="<%= loading_text %>" name="loading_text"/>
									</div>	
							</label></div>
						</div>
					<label><input type="radio" name="untype" value="ajax" class="pb-un-chose-type" <%- untype === 'ajax' ? 'checked' : '' %>/><h4><?php _e('Ajax Pagination', 'unlimited'); ?></h4></label>
				</div>	
			</fieldset>
			
			<fieldset class="pb-un-form-section">
				<legend><?php _e('Selectors', 'unlimited'); ?></legend>
				<div class="pb-un-field-row pb-clr"><label>
					<span class="pb-un-label"><?php _e('Content', 'unlimited'); ?>:</span>
					<div class="pb-un-input-wrapper">
						<input value="<%= content %>" name="content"/>
						<span><?php _e('Element containing posts', 'unlimited'); ?></span>
					</div>
				</label></div>
				<div class="pb-un-field-row pb-clr"><label>
					<span class="pb-un-label"><?php _e('Post', 'unlimited'); ?>:</span>
					<div class="pb-un-input-wrapper">
						<input value="<%= post %>" name="post"/>
						<span><?php _e('Single post', 'unlimited'); ?></span>
					</div>
				</label></div>
				<div class="pb-un-field-row pb-clr"><label>
					<span class="pb-un-label"><?php _e('Navigation', 'unlimited'); ?>:</span>
					<div class="pb-un-input-wrapper">
						<input value="<%= nav %>" name="nav"/>
						<span><?php _e('Element containing post-navigation', 'unlimited'); ?></span>
					</div>
				</label></div>
				<div class="pb-un-field-row pb-clr"><label>
					<span class="pb-un-label"><?php _e('Next', 'unlimited'); ?>:</span>
					<div class="pb-un-input-wrapper">
						<input value="<%= next %>" name="next"/>
						<span><?php _e("Post-navigation 'Next' button", 'unlimited'); ?></span>
					</div>
				</label></div>
			</fieldset>
		</div>
		
		<div class="pb-inline">
			<fieldset class="pb-un-form-section">
				<legend><?php _e('Messages', 'unlimited'); ?></legend>
				<div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Loader Image', 'unlimited'); ?></span>
						<div class="pb-un-input-wrapper">
							<input value="<%= loader_img_url %>" class="pb-hidden" name="loader_img_url"/>
							<input value="<%= loader_img_name %>"  name="loader_img_name" class="pb-hidden"/>
							<input value="<%= loader_img_name %>" class="pb-un-loader-name" disabled/>
							<img src="<%= loader_img_url %>" class="pb-un-loader-img"/>
							<input type="file" name="loader_img" class="pb-un-loader-file pb-hidden"/>
							<button class="pb-un-change-loader button"><?php _e('Change', 'unlimited'); ?></button>
						</div>	
					</label></div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Posts finished', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input value="<%= no_more_text %>" name="no_more_text"/>
							</div>	
					</label></div>
				</div>
			</fieldset>
			
			<fieldset class="pb-un-form-section pb-hidden">
				<legend><?php _e('History', 'unlimited'); ?></legend>
				<div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Enable', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input type="checkbox" name="history" <%- history === 'on' ? 'checked' : '' %>/>
							</div>	
					</label></div>
				</div>
			</fieldset>
			
			<fieldset class="pb-un-form-section pb-hidden">
				<legend><?php _e('Scroll', 'unlimited'); ?></legend>
				<div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('To', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input value="<%= scrollto %>" name="scrollto"/>
								<span><?php _e("'html, body' scrolls to top", 'unlimited'); ?></span>
							</div>	
					</label></div>
				</div>
			</fieldset>
			
			<fieldset class="pb-un-form-section">
				<legend><?php _e('Meta', 'unlimited'); ?></legend>
				<div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Name', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input value="<%= name %>" name="name"/>
								<span><?php _e('Form Identifier', 'unlimited'); ?></span>
							</div>	
					</label></div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Enable', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input type="checkbox" name="status" <%- status === 'on' ? 'checked' : '' %>/>
								<input type="hidden" name="key" value="<%= key %>"/>
							</div>	
					</label></div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Scroll to Top', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input type="checkbox" name="scroll_to_top" <%- scroll_to_top === 'on' ? 'checked' : '' %>/>
							</div>	
					</label></div>
				</div>
			</fieldset>
			
			<fieldset class="pb-un-form-section auto-load-section <%- untype === 'scroll' ? '' : 'pb-hidden' %>">
				<legend><?php _e('Auto-load', 'unlimited'); ?></legend>
				<div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Can opt-out', 'unlimited'); ?></span>
							<div class="pb-un-input-wrapper">
								<input class="pb-un-auto-load" type="checkbox" <%- can_opt_out === 'on' ? 'checked' : '' %> name="can_opt_out"/>
							</div>	
					</label></div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Disable', 'unlimited'); ?> <?php _e('auto-load text', 'unlimited'); ?>:</span>
							<div class="pb-un-input-wrapper">
								<input name="stop_text" value="<%= stop_text %>" />
							</div>	
					</label></div>
					<div class="pb-un-field-row pb-clr"><label>
						<span class="pb-un-label"><?php _e('Enable', 'unlimited'); ?> <?php _e('auto-load text', 'unlimited'); ?>:</span>
							<div class="pb-un-input-wrapper">
								<input name="start_text" value="<%= start_text %>" />
							</div>	
					</label></div>
				</div>
			</fieldset>
			
		</div>
		<div class="">
			<button class="pb-un-save button button-primary"><?php _e('Save', 'unlimited'); ?></button>
			<% if(key){ %> <button class="pb-un-delete button button-primary"><?php _e('Delete', 'unlimited'); ?></button> <% } %>
		</div>
	</form>		
</script>	

<script type="text/javascript">
	<?php
		$terms = array(
			'load_more' => __('Load more', 'unlimited'),
			'loading' => __('Loading', 'unlimited'),
			'no_more_posts' => __('No more posts to show', 'unlimited'),
			'enable' => __('Enable', 'unlimited'),
			'disable' => __('Disable', 'unlimited'),
			'autoload' => __('Auto-load', 'unlimited'),
			'saving' => __('Saving', 'unlimited'),
			'deleting' => __('Deleting', 'unlimited'),
			'settings' => __('Settings', 'unlimited'),
			'something_wrong' => __('Something\'s wrong, please try again or reload the page', 'unlimited')
		);
	?>
	var wpb_translated_terms = <?php echo json_encode( $terms ); ?>
</script>
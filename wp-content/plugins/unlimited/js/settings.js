jQuery(document).ready(function($){
	WPB = {'un':0, 'uns':{}, 'store':{}, 'terms': wpb_translated_terms};
	
	WPB.theme_selectors = {
		'Twenty Fifteen': ['#content', 'article.post', '.navigation.pagination', '.next'],
		'Twenty Fourteen': ['#content', 'article.post', '.navigation.paging-navigation', '.next'],
		'unnone': ['', '', '', ''],
	};
		
	WPB.server = $('#pb-un-wrapper').data();		
	WPB.selectors = WPB.theme_selectors[WPB.server.theme] || WPB.theme_selectors['unnone'];
	
	WPB.formpost = function(data, success, error){
		$.ajax({
			url: 'admin-ajax.php',
			type: 'POST',
			data: data,
			contentType:false,
			processData:false,
			success: success,
			error: error
		});
	};
	
	WPB.post = function(data, success, error){
		$.ajax({
			url: 'admin-ajax.php',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: success,
			error: error
		});
	};
	
	WPB.get = function(data, success, error){
		$.ajax({
			url: 'admin-ajax.php',
			type: 'GET',
			data: data,
			dataType: 'json',
			success: success,
			error: error
		});
	};
	
	WPB.template = function(selector){
		return _.template($(selector).html());
	};
	
	WPB.form = function(form){
		var o = {};
		var inputs = $(form).serializeArray();
		$.each(inputs, function() {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		inputs = $(form).find('input[type="checkbox"]');
		$.each(inputs, function(){
			o[this.name] = o[this.name] ? o[this.name] : '';
		});
		return o;
	};
	
	function UN(id){
		this.id = id || WPB.un;
		this.form_id = 'pb-un-form-'+this.id;
		this.selector = '#'+this.form_id;
	}
	
	UN.prototype.init = function(id){
		this.item_id = id;
		this.data = WPB.store[id];
		this.data.theme = WPB.theme_selectors[WPB.server.theme] ? WPB.server.theme : '';
		this.render();
	};
	
	UN.prototype.dummy = function(){
		this.data = {
			'key': '',
			'threshold': 100,
			'load_more_text': WPB.terms.load_more,
			'loading_text': WPB.terms.loading+'...',
			'untype': 'scroll',
			'content': WPB.selectors[0],
			'post':WPB.selectors[1],
			'nav': WPB.selectors[2],
			'next': WPB.selectors[3],
			'loader_img_url': WPB.server.site+'/wp-admin/images/loading.gif',
			'loader_img_name': 'loading.gif',
			'no_more_text': WPB.terms.no_more_posts,
			'history': 'on',
			'scrollto': 'html, body',
			'name': WPB.terms.settings+'-'+this.id,
			'status': 'on',
			'can_opt_out': 'on',
			'scroll_to_top': 'on',
			'stop_text': WPB.terms.disable+' '+WPB.terms.auto_load,
			'start_text': WPB.terms.enable+' '+WPB.terms.auto_load,
			'theme': WPB.theme_selectors[WPB.server.theme] ? WPB.server.theme : ''
		}
		this.render();
	};
	
	UN.prototype.render = function(){
		var un = this;
		un.data.form_id = un.form_id;
		$('#pb-un-editor').html(WPB.template('#pb-un-form-tmpl')(un.data));
		$(un.selector +' .pb-un-chose-type:checked').parent().next('.pb-un-chosen-type').removeClass('pb-hidden');
		un.form = $(un.selector);
		$('#pb-un-add-new').addClass('pb-hidden');
		un.events();
	};
	
	UN.prototype.events = function(){
		var un = this;
		$(document).on('change', un.selector +' .pb-un-chose-type', function(e){
			if($(this).val() === 'scroll'){
				$('.auto-load-section').removeClass('pb-hidden');
			} else {
				$('.auto-load-section').addClass('pb-hidden');
			}
			
			un.form.find('.pb-un-chosen-type').addClass('pb-hidden');
			$(this).parent().next('.pb-un-chosen-type').removeClass('pb-hidden');
		});
		$(document).on('click', un.selector +' .pb-un-save', function(e){
			e.preventDefault();
			un.save();
		});
		$(document).on('click', un.selector +' .pb-un-delete', function(e){
			e.preventDefault();
			un.del();
		});
		$(document).on('click', un.selector +' .pb-un-change-loader', function(e){
			e.preventDefault();
			$(this).prev().trigger('click');
		});
		$(document).on('change', un.selector +' .pb-un-loader-file', function(e){
			e.preventDefault();
			if($(this).val()){
				un.loader(e.target.files[0]);
			}
		});
		$(document).on('change', un.selector +' .pb-un-auto-load', function(e){
			if($(this).attr('checked')){
				$(this).parents('.pb-un-field-row').nextAll('.pb-un-field-row').removeClass('pb-hidden');
			} else {
				$(this).parents('.pb-un-field-row').nextAll('.pb-un-field-row').addClass('pb-hidden');
			}
		});
	};
	
	UN.prototype.loader = function(pic){
		var un = this;
		var	reader = new FileReader();
		reader.onload = (function(theFile) {
			return function(e) {
				$(un.selector +' .pb-un-loader-img').attr('src', e.target.result);
				$(un.selector +' .pb-un-loader-name').val(pic.name);
				un.pic = {'name':pic.name, 'url':e.target.result, 'pic':pic};
			};
		})(pic);
		reader.readAsDataURL(pic);
		un.pic = pic;
	}
	
	UN.prototype.save = function(){
		var un = this;
		var data = WPB.form(un.selector);
		
		$('.pb-un-save').text(WPB.terms.saving+'...');
		$('.pb-un-delete').addClass('pb-hidden');
		
		var form = new FormData();
			form.append('un_data', JSON.stringify(data));
			if(un.pic) {
				form.append('loader_img', un.pic.pic);
				data.loader_img_name = un.pic.name;
				data.loader_img_url = un.pic.url;
			}
			form.append('action', 'pb_un_save');
			
		WPB.formpost(form, function(re){
			if(!re){
				$('.pb-un-save').removeClass('button-primary').text(WPB.terms.something_wrong);
			} else {
				data.key = re;
				WPB.store[un.item_id] = data;
				WPB.item(un.item_id, data);
				$('#pb-un-editor').empty();
				$('#pb-un-add-new').removeClass('pb-hidden');
			}
		});
	};
	
	UN.prototype.del = function(){
		var un = this;
		$('.pb-un-delete').text(WPB.terms.deleting+'...');
		$('.pb-un-save').addClass('pb-hidden');
		WPB.post({'action':'pb_un_delete', 'del_key': un.data.key}, function(re){
			if(re){
				delete WPB.store[un.item_id];
				$('#pb-un-editor').empty();
				$('#pb-un-add-new').removeClass('pb-hidden');
			}
		});
	};
	
	WPB.list = function(re){
		re.forEach(function(r, i){
			if(r.scroll_to_top === undefined) r.scroll_to_top = 'on';
			WPB.store[i] = r;
			WPB.item(i, r);
		});
		WPB.formMaker();
	};
	
	WPB.item = function(i, r){
		$('#pb-un-items').append('<div data-id="'+i+'" class="pb-un-item pb-clr '+(r.status === 'on' ? 'pb-un-enabled' : 'pb-un-disabled')+'"><span class="pb-float-left">'+r.name+'</span><div class="pb-float-left"></div></div>');
		WPB.formMaker();
	};
	
	WPB.formMaker = function(){
		$('#pb-un-items').off('click', '.pb-un-item').on('click', '.pb-un-item', function(){
			WPB.uns[++WPB.un] = new UN(WPB.un).init($(this).data('id'));
			$(this).remove();
		})
	};
	
	WPB.get({'action':'pb_un_get'}, function(re){
		re = _.values(re);
		if(re && re.length){
			WPB.list(re);
		} else {
			WPB.uns[++WPB.un] = new UN().dummy();
		}
		$(document).on('click', '#pb-un-add-new', function(e){
			e.preventDefault();
			WPB.uns[++WPB.un] = new UN().dummy();
		})
	});
});
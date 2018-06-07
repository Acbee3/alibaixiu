

// 此模块用来完成 评论的管理（增删改查操作）
// 依赖 jquery 和 template
define(['jquery', 'template', 'nprogress', 'moment', 'twbsPagination'], function ($, template, NProgress, moment) {

	// console.log(moment('2017-07-04 12:00:00').format('YYYY/MM/DD'));
	var size = 10;

	var page = 1;
	// 查看(通过 ajax 请求实现)
	$.ajax({
		url: './comments-list.php',
		type: 'get',
		data: {
			size: size,
			page: page
		},
		dataType: 'json',
		beforesend: function() {
			NProgress.start();
		},
		success: function (info) {
			// info 为 json 数据
			NProgress.done();
			
			console.log(info);

			// for(var i = 0; i < info.data.length; i++) {
			// 	info.data[i].created = moment(info.data[i].created).format('YYYY/MM/DD');
			// }
			
			// 通过 模板引擎将其拼凑成 html
			var html = template('tpl', info);
			
			
			// 添加DOM
            $('tbody').html(html);
            
            $('#pagination').twbsPagination({
				totalPages: info.pages,
				visiblePages: 5,
				prev: '上一页',
				next: '下一页',
				onPageClick: function (event, page) {
					// $('#page-content').text('Page ' + page);
					$.ajax({
						url: './comments-list.php',
						type: 'get',
						data: {
							size: size,
							page: page
						},
						beforeSend: function () {
							// 请求结果
							NProgress.start();
						},
						success: function (info) {
							NProgress.done();
							// console.log(info);
							// 通过 模板引擎将其拼凑成 html
							var html = template('tpl', info);
							
							// console.log(html);
							// 添加DOM
							$('tbody').html(html);
						}
					})
				}
				
			});
		}
	});

	

	// 删除
	$('table').on('click', '.delete', function () {
		var tr = $(this).parents('tr');
		$.ajax({
			url: './comments-delete.php',
			type: 'get',
			data: {
				id: $(this).attr('data-id')
			},
			beforeSend: function () {
				NProgress.start();
			},
			success: function (info) {
				NProgress.done();
				alert(info.msg);

				if(info.code == 200) {
					tr.fadeOut(function () {
						tr.remove();
					});
				}
			}
		})
	})
})
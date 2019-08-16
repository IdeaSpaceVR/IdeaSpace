
document.fonts.ready.then(function() {

		var post_title_textures = document.querySelectorAll('.post-title-texture');
		for (var i = 0; i < post_title_textures.length; i++) {
				var post_title_textures_elems = post_title_textures[i].getElementsByTagName('span');		
				for (var j = 0; j < post_title_textures_elems.length; j++) {
						if (post_title_textures_elems[j].style.color == 'rgb(0, 0, 0)' || post_title_textures_elems[j].style.color == '') {
								post_title_textures_elems[j].style.color = 'rgb(255, 255, 255)';
						}
						post_title_textures[i].style.visibility = 'visible';
				}
				/* update html shader material, even if font color is not changed */
				document.querySelector('#post-title-' + post_title_textures[i].dataset.cid).components.material.shader.__render();
		}


		var nav_arrow_up_all = document.querySelectorAll('.navigation-arrow-up');
		for (var i = 0; i < nav_arrow_up_all.length; i++) {
				/* workaround to refresh texture, otherwise it is not appearing on first loading of page */
				nav_arrow_up_all[i].components.material.shader.__render();
		}


		var nav_arrow_down_all = document.querySelectorAll('.navigation-arrow-down');
		for (var i = 0; i < nav_arrow_down_all.length; i++) {
				/* workaround to refresh texture, otherwise it is not appearing on first loading of page */
				nav_arrow_down_all[i].components.material.shader.__render();
		}


		var post_text_all = document.querySelectorAll('.post-text');
		for (var i = 0; i < post_text_all.length; i++) {
				post_text_all[i].components.material.shader.__render();
	 	}	


		var post_link_all = document.querySelectorAll('.post-link');
		for (var i = 0; i < post_link_all.length; i++) {
				post_link_all[i].components.material.shader.__render();
		}	


		/* update html shader material, even if font color is not changed */
		if (document.querySelector('#about') != null) {
				document.querySelector('#about').components.material.shader.__render();
				document.querySelector('#about-link').components.material.shader.__render();
		}


		var blog_post_rotate_all = document.querySelectorAll('.blog-post-rotate');
		for (var i = 0; i < blog_post_rotate_all.length; i++) {
				/* workaround to refresh texture, otherwise it is not appearing on first loading of page */
				blog_post_rotate_all[i].components.material.shader.__render();
		}


		document.querySelector('#ideaspacevr').components.material.shader.__render();		
		
});



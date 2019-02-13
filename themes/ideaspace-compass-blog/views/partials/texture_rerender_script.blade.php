
document.fonts.onloadingdone = function(fontFaceSetEvent) {

		var post_title_textures = document.querySelectorAll('.post-title-texture');
		for (var i = 0; i < post_title_textures.length; i++) {
				if (post_title_textures[i].getElementsByTagName('span')[0].style.color == 'rgb(0, 0, 0)' || post_title_textures[i].getElementsByTagName('span')[0].style.color == '') {
						post_title_textures[i].getElementsByTagName('span')[0].style.color = 'rgb(255, 255, 255)';
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

}

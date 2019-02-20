
document.fonts.onloadingdone = function(fontFaceSetEvent) {

		var post_title_textures = document.querySelectorAll('.post-title-texture');
		for (var i = 0; i < post_title_textures.length; i++) {
				var post_title_textures_elems = post_title_textures[i].getElementsByTagName('span');		
				for (var j = 0; j < post_title_textures_elems.length; j++) {
						if (post_title_textures_elems[j].style.color == 'rgb(0, 0, 0)' || post_title_textures_elems[j].style.color == '') {
								post_title_textures_elems[j].style.color = 'rgb(255, 255, 255)';
						}
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


		/*var about_texture = document.querySelector('#about-texture');
		var about_texture_elems = about_texture.getElementsByTagName('span');
		for (var i = 0; i < about_texture_elems.length; i++) {
				if (about_texture_elems[i].style.color == 'rgb(0, 0, 0)' || about_texture_elems[i].style.color == '') {
						about_texture_elems[i].style.color = 'rgb(255, 255, 255)';
				}
		}*/
		/* update html shader material, even if font color is not changed */
		document.querySelector('#about').components.material.shader.__render();
		document.querySelector('#about-link').components.material.shader.__render();

}



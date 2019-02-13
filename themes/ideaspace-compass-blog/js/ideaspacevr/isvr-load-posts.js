/* global */
var posts = {

		load: function (next_page_url, meters, posts_per_page, total_posts, positions, post_counter) {

				this.next_page_url = next_page_url;
				this.meters_between_posts = meters;
				this.posts_per_page = posts_per_page;
				this.total_posts = total_posts;
				this.positions = positions;
				this.post_counter = post_counter;

				this.xmlhttp = new XMLHttpRequest();
				this.xmlhttp.onreadystatechange = this.responseHandler.bind(this);
				this.xmlhttp.open('GET', this.next_page_url, true);
				this.xmlhttp.send();

		}, /* load */


		responseHandler: function () {

        var self = this;


        if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {

            var obj = JSON.parse(this.xmlhttp.responseText);

            for (var i=0; i<obj['blog-posts'].length; i++) {

								var cid = obj['blog-posts'][i]['post-title-north']['#content-id'];
								var textures = document.querySelector('#textures');
								var posts_wrapper = document.querySelector('#posts-wrapper');


								/* posts wrapper animation nav */
								posts_wrapper.setAttribute('animation__nav_up_' + cid, { property: 'position', dur: 1, easing: 'linear', to: '0 ' + ((this.post_counter - 1) * this.meters_between_posts) + ' 0', startEvents: 'nav_up_' + cid });
								posts_wrapper.setAttribute('animation__nav_down_' + cid, { property: 'position', dur: 1, easing: 'linear', to: '0 ' + ((this.post_counter * this.meters_between_posts) + 10) + ' 0', startEvents: 'nav_down_' + cid });


								var post = document.createElement('a-entity');
								post.setAttribute('position', { x: 0, y: -(this.post_counter * this.meters_between_posts), z: 0 }); 
								post.id = 'post-' + cid;
								post.className = 'post post-' + this.post_counter + ' collidable';
								posts_wrapper.appendChild(post);


								/* blog post title textures and entities */	
								this.createBlogPostTitleContent(cid, this.positions, textures, post, obj, i, this.post_counter, this.total_posts, obj['next_page_url'], this.meters_between_posts, this.posts_per_page);								


								/* blog post textures and entities */
								this.createBlogPostContent('north-east', cid, this.positions[1], textures, post, obj, i);
								this.createBlogPostContent('east', cid, this.positions[2], textures, post, obj, i);
								this.createBlogPostContent('south-east', cid, this.positions[3], textures, post, obj, i);
								this.createBlogPostContent('south', cid, this.positions[4], textures, post, obj, i);
								this.createBlogPostContent('south-west', cid, this.positions[5], textures, post, obj, i);
								this.createBlogPostContent('west', cid, this.positions[6], textures, post, obj, i);
								this.createBlogPostContent('north-west', cid, this.positions[7], textures, post, obj, i);

								this.post_counter++;

            } /* for */


						document.fonts.onloadingdone = function(fontFaceSetEvent) {

								var post_title_all = document.querySelectorAll('.post-title');
								for (var i = 0; i < post_title_all.length; i++) {
										/* workaround to refresh texture, otherwise some fonts might not appear */
										post_title_all[i].components.material.shader.__render();
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
										/* workaround to refresh texture, otherwise some fonts might not appear */
										post_text_all[i].components.material.shader.__render();
								}
						}


        } /* if */

    }, /* responseHandler */


		createBlogPostContent: function (id, cid, position, textureParent, post, obj, i) {

				if (obj['blog-posts'][i]['post-display-' + id]['#value'] == 'text') {

						var texture = document.createElement('div');
						texture.id = 'post-text-' + id + '-texture-' + cid;
						texture.dataset.cid = cid;
						texture.className = 'post-text-' + id + '-texture post-text-texture';
						texture.style.backgroundColor = obj['blog-posts'][i]['post-text-image-background-color-' + id]['#value'];
						texture.innerHTML = obj['blog-posts'][i]['post-text-' + id]['#value'];
						textures.appendChild(texture);

						var wrapper = document.createElement('a-rounded');
						wrapper.id = 'post-text-wrapper-' + id + '-' + cid;
						wrapper.setAttribute('position', { x: position['x'], y: 0, z: position['z'] });
						wrapper.setAttribute('color', obj['blog-posts'][i]['post-text-image-background-color-' + id]['#value']);
						wrapper.setAttribute('look-at', { x: 0, y: 0, z: 0 });
						wrapper.setAttribute('width', 2);
						wrapper.setAttribute('height', 3);
						wrapper.setAttribute('top-left-radius', 0.06);
						wrapper.setAttribute('top-right-radius', 0.06);
						wrapper.setAttribute('bottom-left-radius', 0.06);
						wrapper.setAttribute('bottom-right-radius', 0.06);

						var text = document.createElement('a-entity');
						text.id = 'post-text-' + id + '-' + cid;
						text.className = 'post-text';
						text.setAttribute('geometry', { primitive: 'plane', width: 1.8 });
						text.setAttribute('position', { x: 0, y: 0, z: 0.001 });
						text.setAttribute('material', { shader: 'html', target: '#post-text-' + id + '-texture-' + cid, transparent: true, ratio: 'width' });

						var height_meters = (texture.offsetHeight * wrapper.getAttribute('width')) / texture.offsetWidth;
						wrapper.setAttribute('height', height_meters);
				
						wrapper.appendChild(text);
						post.appendChild(wrapper);

				} else if (obj['blog-posts'][i]['post-display-' + id]['#value'] == 'link') {

						var texture = document.createElement('div');
						texture.id = 'post-link-' + id + '-texture-' + cid;
						texture.dataset.cid = cid;
						texture.className = 'post-link-' + id + '-texture post-link-texture';
						texture.style.backgroundColor = obj['blog-posts'][i]['post-text-image-background-color-' + id]['#value'];
						if (obj['blog-posts'][i]['post-link-text-' + id]['#value'].trim() != '') {
								texture.innerHTML = obj['blog-posts'][i]['post-link-text-' + id]['#value'];
						} else if (obj['blog-posts'][i]['post-link-' + id]['#value'].trim() != '') {
								texture.innerHTML = obj['blog-posts'][i]['post-link-' + id]['#value'];
						}
						textures.appendChild(texture);

						texture = document.createElement('div');
						texture.id = 'post-link-' + id + '-texture-' + cid + '-active';
						texture.dataset.cid = cid;
						texture.className = 'post-link-' + id + '-texture post-link-texture';
						texture.style.color = '#0080e5'; 
						texture.style.backgroundColor = obj['blog-posts'][i]['post-text-image-background-color-' + id]['#value'];
						if (obj['blog-posts'][i]['post-link-text-' + id]['#value'].trim() != '') {
								texture.innerHTML = obj['blog-posts'][i]['post-link-text-' + id]['#value'];
						} else if (obj['blog-posts'][i]['post-link-' + id]['#value'].trim() != '') {
								texture.innerHTML = obj['blog-posts'][i]['post-link-' + id]['#value'];
						}
						textures.appendChild(texture);

						var wrapper_active = document.createElement('a-rounded');
						wrapper_active.id = 'post-link-wrapper2-' + id + '-' + cid;
						if (position['x'] == -3) {
								wrapper_active.setAttribute('position', { x: (position['x'] - 0.001), y: 0, z: position['z'] });
						} else {
								wrapper_active.setAttribute('position', { x: position['x'], y: 0, z: position['z'] });
						}
						wrapper_active.setAttribute('color', '#0080e5');
						wrapper_active.setAttribute('visible', false);
						wrapper_active.setAttribute('look-at', { x: 0, y: 0, z: 0 });
						wrapper_active.setAttribute('width', 2);
						wrapper_active.setAttribute('height', 0.5);
						wrapper_active.setAttribute('top-left-radius', 0.06);
						wrapper_active.setAttribute('top-right-radius', 0.06);
						wrapper_active.setAttribute('bottom-left-radius', 0.06);
						wrapper_active.setAttribute('bottom-right-radius', 0.06);

						var wrapper = document.createElement('a-rounded');
						wrapper.id = 'post-link-wrapper-' + id + '-' + cid;
						wrapper.setAttribute('isvr-link-hover', { id: 'post-link-wrapper2-' + id + '-' + cid });
						if (position['z'] < 0) {
								wrapper.setAttribute('position', { x: position['x'], y: 0, z: (position['z'] + 0.001) });
						} else {
								wrapper.setAttribute('position', { x: position['x'], y: 0, z: (position['z'] - 0.001) });
						}
						wrapper.setAttribute('look-at', { x: 0, y: 0, z: 0 });
						wrapper.setAttribute('color', obj['blog-posts'][i]['post-text-image-background-color-' + id]['#value']);
						wrapper.setAttribute('width', 1.95);
						wrapper.setAttribute('height', 0.45);
						wrapper.setAttribute('top-left-radius', 0.06);
						wrapper.setAttribute('top-right-radius', 0.06);
						wrapper.setAttribute('bottom-left-radius', 0.06);
						wrapper.setAttribute('bottom-right-radius', 0.06);

						var link = document.createElement('a-entity');
						link.setAttribute('position', { x: 0, y: 0, z: 0.001 });
						link.setAttribute('material', { shader: 'html', target: '#post-link-' + id + '-texture-' + cid, transparent: true, ratio: 'width' });
						if (obj['blog-posts'][i]['post-link-' + id]['#value'].trim() != '') {
								link.setAttribute('link', { href: obj['blog-posts'][i]['post-link-' + id]['#value'], visualAspectEnabled: false });	
						}
						link.setAttribute('geometry', { primitive: 'plane', width: 1.8 });
						link.className = 'post-link';

						wrapper.appendChild(link);
						post.appendChild(wrapper);
						post.appendChild(wrapper_active);

				} else if (obj['blog-posts'][i]['post-display-' + id]['#value'] == 'image' && ('post-image-' + id) in obj['blog-posts'][i]) {

						var imageTexture = new Image();
						imageTexture.onload = (function(cid, id, textures, position) {
								return function() {
										/* Image() is loaded but we need an img tag as well */
										var texture = document.createElement('img');
										texture.id = 'post-image-' + id + '-texture-' + cid;
										texture.dataset.cid = cid;
										texture.className = 'post-image-' + id + '-texture post-image-texture';
										texture.src = this.src;
										texture.crossOrigin = 'anonymous';
										textures.appendChild(texture);

										var wrapper = document.createElement('a-rounded');
										wrapper.id = 'post-image-wrapper-' + id + '-' + cid;
										wrapper.setAttribute('position', { x: position['x'], y: 0, z: position['z'] });
										wrapper.setAttribute('look-at', { x: 0, y: 0, z: 0 });
										wrapper.setAttribute('color', obj['blog-posts'][i]['post-text-image-background-color-' + id]['#value']);
										wrapper.setAttribute('width', 2);
										/* use imageTexture because it is loaded and width and height is set */
										wrapper.setAttribute('height', ((imageTexture.height * wrapper.getAttribute('width')) / imageTexture.width) + 0.08);
										wrapper.setAttribute('top-left-radius', 0.06);
										wrapper.setAttribute('top-right-radius', 0.06);
										wrapper.setAttribute('bottom-left-radius', 0.06);
										wrapper.setAttribute('bottom-right-radius', 0.06);

										if (obj['blog-posts'][i]['post-image-' + id]['#mime-type'] == 'image/gif') {
												var image = document.createElement('a-image');
												image.id = 'post-image-' + id + '-' + cid;
												image.setAttribute('position', { x: 0, y: 0, z: 0.001 });
												image.setAttribute('shader', 'gif');
												image.setAttribute('src', '#post-image-' + id + '-texture-' + cid);
												if (obj['blog-posts'][i]['post-image-' + id]['#width'] > obj['blog-posts'][i]['post-image-' + id]['#height']) {
														image.setAttribute('width', 1.8);
														image.setAttribute('height', 0.9);
												} else if (obj['blog-posts'][i]['post-image-' + id]['#width'] < obj['blog-posts'][i]['post-image-' + id]['#height']) {
														image.setAttribute('width', 1.8);
														image.setAttribute('height', 3.6);
												} else {
														image.setAttribute('width', 1.8);
														image.setAttribute('height', 1.8);
												}
										} else {
												var image = document.createElement('a-image');
												image.id = 'post-image-' + id + '-' + cid;
												image.setAttribute('position', { x: 0, y: 0, z: 0.001 });
												image.setAttribute('src', '#post-image-' + id + '-texture-' + cid);
												if (obj['blog-posts'][i]['post-image-' + id]['#width'] > obj['blog-posts'][i]['post-image-' + id]['#height']) {
														image.setAttribute('width', 1.8);
														image.setAttribute('height', 0.9);
												} else if (obj['blog-posts'][i]['post-image-' + id]['#width'] < obj['blog-posts'][i]['post-image-' + id]['#height']) {
														image.setAttribute('width', 1.8);
														image.setAttribute('height', 3.6);
												} else {
														image.setAttribute('width', 1.8);
														image.setAttribute('height', 1.8);
												}
										}

										wrapper.appendChild(image);
										post.appendChild(wrapper);

								};
						}(cid, id, textures, position));
						imageTexture.src = obj['blog-posts'][i]['post-image-' + id]['#uri']['#value'];
				}

		}, /* createBlogPostContent */


		createBlogPostTitleContent: function (cid, positions, textures, post, obj, i, post_counter, total_posts, next_page_url, meters, posts_per_page) {

				var title_texture = document.createElement('div');
				title_texture.id = 'post-title-texture-' + cid;
				title_texture.dataset.cid = cid;
				title_texture.className = 'post-title-texture';
				title_texture.innerHTML = obj['blog-posts'][i]['post-title-north']['#value'] + '<p>&nbsp;</p>'; 
				textures.appendChild(title_texture);

				if (title_texture.getElementsByTagName('span')[0].style.color == 'rgb(0, 0, 0)' || title_texture.getElementsByTagName('span')[0].style.color == '') {
        		title_texture.getElementsByTagName('span')[0].style.color = 'rgb(255, 255, 255)';
				}

				var title = document.createElement('a-entity');			
				title.id = 'post-title-' + cid;
				title.className = 'post-title';
				title.dataset.cid = cid;
				title.setAttribute('geometry', { primitive: 'plane', width: 2 });
				title.setAttribute('position', { x: this.positions[0]['x'], y: 0, z: this.positions[0]['z'] });
				title.setAttribute('look-at', { x: 0, y: 0, z: 0 });
				title.setAttribute('material', { shader: 'html', target: '#post-title-texture-' + cid, transparent: true, ratio: 'width' });

				if (post_counter > 0) {
						var nav_up = document.createElement('a-entity');			
						nav_up.id = 'navigation-arrow-up-' + cid;
						nav_up.className = 'navigation-arrow-up collidable';
						nav_up.setAttribute('isvr-blog-post-nav-up', { id: 'navigation-arrow-up-' + cid, cid: cid });
						nav_up.setAttribute('geometry', { primitive: 'plane', width: 2, height: 2 });
						nav_up.setAttribute('position', { x: -1.15, y: 0, z: -0.001 });
						nav_up.setAttribute('material', { shader: 'html', target: '#navigation-arrow-up-texture', transparent: true, ratio: 'width' });

						title.appendChild(nav_up);
				} else {
						var nav_up = document.createElement('a-entity');			
						nav_up.id = 'navigation-arrow-up-' + cid;
						nav_up.className = 'navigation-arrow-up';
						nav_up.setAttribute('geometry', { primitive: 'plane', width: 2, height: 2 });
						nav_up.setAttribute('position', { x: -1.15, y: 0, z: -0.001 });
						nav_up.setAttribute('material', { shader: 'html', target: '#navigation-arrow-up-inactive-texture', transparent: true, ratio: 'width' });

						title.appendChild(nav_up);
				}

				if ((total_posts - 1) > post_counter) {
						var nav_down = document.createElement('a-entity');			
						nav_down.id = 'navigation-arrow-down-' + cid;
						nav_down.className = 'navigation-arrow-down collidable';
						nav_down.setAttribute('isvr-blog-post-nav-down', { id: 'navigation-arrow-down-' + cid, cid: cid, next_page_url: next_page_url, meters: meters, posts_per_page: posts_per_page, total_posts: total_posts, post_counter: post_counter  });
						nav_down.setAttribute('geometry', { primitive: 'plane', width: 2, height: 2 });
						nav_down.setAttribute('position', { x: 1.15, y: 0, z: -0.001 });
						nav_down.setAttribute('material', { shader: 'html', target: '#navigation-arrow-down-texture', transparent: true, ratio: 'width' });

						title.appendChild(nav_down);
				} else {
						var nav_down = document.createElement('a-entity');			
						nav_down.id = 'navigation-arrow-down-' + cid;
						nav_down.className = 'navigation-arrow-down';
						nav_down.setAttribute('geometry', { primitive: 'plane', width: 2, height: 2 });
						nav_down.setAttribute('position', { x: 1.15, y: 0, z: -0.001 });
						nav_down.setAttribute('material', { shader: 'html', target: '#navigation-arrow-down-inactive-texture', transparent: true, ratio: 'width' });

						title.appendChild(nav_down);
				}
				
				post.appendChild(title);

		} /* createBlogPostTitleContent */




};



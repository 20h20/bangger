/*include /libs/jquery.core.js*/
/*include /libs/slick.js*/
/*include /libs/smoothscroll.js*/
/*include /libs/move.js*/


jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};

var Master = {
    onscroll : function(){
        cg_Move.scroll_slides();
    },
};

$(window).on( 'scroll', function(){
    Master.onscroll();
});


(function($) { 
	var Master = {
		onready : function(){

			/////////////////// Wavy effect au hover sur les réalisateurs ///////////////////
			function applyLastNameEffect() {
				if (window.matchMedia('(max-width: 1023px)').matches) {
					console.log('Mobile → aucun effet appliqué');
					return;
				}
				document.querySelectorAll('.content-lastname').forEach(function(content) {
					if (content.dataset.transformed === "true") return;
			
					var text = content.textContent.trim();
					content.textContent = '';
					content.dataset.transformed = "true";
			
					for (var i = 0; i < text.length; i++) {
						var letter = text[i];
			
						var charSpan = document.createElement('span');
						charSpan.className = 'char';
						charSpan.style.setProperty('--i', i);
			
						var frontSpan = document.createElement('span');
						frontSpan.className = 'front';
						frontSpan.textContent = letter;
			
						var backSpan = document.createElement('span');
						backSpan.className = 'back';
						backSpan.textContent = letter;
			
						charSpan.appendChild(frontSpan);
						charSpan.appendChild(backSpan);
						content.appendChild(charSpan);
					}
				});
			
				document.querySelectorAll('.el-inner').forEach(function(inner) {
					var lastname = inner.querySelector('.content-lastname');
					if (!lastname) return;
			
					inner.addEventListener('mouseenter', function() {
						lastname.classList.add('hovered');
					});
					inner.addEventListener('mouseleave', function() {
						lastname.classList.remove('hovered');
					});
				});
			}
			
			window.addEventListener('load', applyLastNameEffect);
			


			///////////////// Vidéo en fullscreen au hover sur les réalisateurs /////////////////
			function applyVideoEffect() {
				var elInners = document.querySelectorAll('.el-inner');
				var videoContainer = document.querySelector('.el-video');
				var video = videoContainer ? videoContainer.querySelector('video') : null;
				if (!videoContainer || !video) return;
				for (var i = 0; i < elInners.length; i++) {
					elInners[i].addEventListener('mouseenter', function () {
						var videoUrl = this.getAttribute('data-video');
						if (videoUrl) {
							video.pause();
							video.setAttribute('src', videoUrl);
							video.load();
							videoContainer.style.opacity = 1;
							video.play().catch(function (e) {
								console.warn('Impossible de jouer la vidéo :', e);
							});
						}
					});
					elInners[i].addEventListener('mouseleave', function () {
						videoContainer.style.opacity = 0;
						video.pause();
					});
				}
			}
			if (!document.body.classList.contains('home')) {
				applyVideoEffect();
			}


			///////////////// Fonctionnement des filtres sur Smartphone /////////////////
			$('.filters-menu').on('click', function(event){
				event.stopPropagation();
				$('.tags-list').toggleClass('list--open');
				$('.filters-menu').toggleClass('filters-menu-click');
			});

			$('.filters-inner a').filter(function(){
				return this.href === location.href;
			}).addClass('el--active');

			$(document).on('click', function(event) {
				if (!$(event.target).closest('.filters-inner').length) {
					$('.tags-list').removeClass('list--open');
					$('.filters-menu').removeClass('filters-menu-click');
				}
			});

			$('.filters-inner').on('click', function(event){
				event.stopPropagation();
			});
			


			/////////////////// SMOOTHSCOLL ///////////////////
			CBO_Smoothscroll.init();

			
			/////////////////// MEGA MENU ///////////////////
			var categories = document.querySelectorAll('header .list-el');
			var items = document.querySelectorAll('.list-item');
			function applyHighlight(termId) {
				for (var j = 0; j < items.length; j++) {
					var item = items[j];
					var termIds = item.getAttribute('data-term-ids').split(',');
					item.classList.add('dimmed');
					if (termIds.indexOf(termId) !== -1) {
						item.classList.add('highlight');
					} else {
						item.classList.remove('highlight');
					}
				}
			}

			function resetHighlight() {
				for (var j = 0; j < items.length; j++) {
					items[j].classList.remove('highlight');
					items[j].classList.remove('dimmed');
				}
				for (var k = 0; k < categories.length; k++) {
					categories[k].classList.remove('active');
				}
			}

			for (var i = 0; i < categories.length; i++) {
				(function(category) {
					var termId = category.getAttribute('data-term-id');
					category.addEventListener('mouseenter', function() {
						if (window.innerWidth > 768) {
							applyHighlight(termId);
						}
					});

					category.addEventListener('mouseleave', function() {
						if (window.innerWidth > 768) {
							resetHighlight();
						}
					});

					category.addEventListener('click', function(e) {
						if (window.innerWidth <= 768) {
							e.preventDefault();
							var isActive = category.classList.contains('active');
							resetHighlight();

							if (!isActive) {
							
							}
						}
					});
				})(categories[i]);
			}

			var menuLink = document.querySelector('.menu-item-directors');
			var megaMenu = document.getElementById('mega-menu-directors');
			if (menuLink && megaMenu) {
				menuLink.addEventListener('mouseenter', function() {
					megaMenu.style.display = 'flex';
				});
				menuLink.addEventListener('mouseleave', function() {
					setTimeout(function() {
						megaMenu.style.display = 'none';
					}, 200);
				});
				megaMenu.addEventListener('mouseenter', function() {
					megaMenu.style.display = 'flex';
				});
				megaMenu.addEventListener('mouseleave', function() {
					megaMenu.style.display = 'none';
				});
			}


			//////////////// STICKY ////////////////
			$(window).scroll(function(){
				if($(window).scrollTop()>80){
					$("header").addClass('header-scroll');
				}else{
					$("header").removeClass('header-scroll');
				}
			})
			.scroll();


			/////////////////// SMARTPHONE NAVIGATION ///////////////////
			$('header .burger-menu').on('click', function(){
				$('.header-nav').toggleClass('nav--open');
				$('.burger-menu').toggleClass('burger-menu-cross');
				$('html').toggleClass('html--hidden');
			});


			/////////////////// Animate letters on herovideo ///////////////////
			if ($('body .cbo-herovideo.herovideo--blocks').length > 0) {
				var element = document.getElementById("typing-text");
				var typingSpeed = 4000;
				var phraseIndex = 0;

				function showPhrase() {
					if (!titles[phraseIndex]) return;
					element.textContent = titles[phraseIndex];
					element.classList.add("visible");
					setTimeout(function() {
						element.classList.remove("visible");
						phraseIndex = (phraseIndex + 1) % titles.length;
						setTimeout(showPhrase, 1000);
					}, typingSpeed);
				}
				showPhrase();
			}


			/////////////////// ALOADER ///////////////////
			var loader = document.getElementById('page-loader');
			if (loader) {
				document.body.style.overflow = 'hidden';
				setTimeout(function () {
					loader.classList.add('fade-out');
					setTimeout(function () {
						loader.remove();
						document.body.style.overflow = '';
					}, 500);
				}, 3000);
			}


			/////////////////// Ajax pour le chargement de toutes les vidéos + Ouverture modale + hovers ///////////////////
			(function () {
				// ================================
				// Hover video effect
				// ================================
				function cboInitHoverEffects(root) {
					root = root || document;
					var cursor = document.querySelector('.movie-cursor');
					if (!cursor) return;
					var videoBlocks = root.querySelectorAll('.movies-list .list-el');

					videoBlocks.forEach(function (videoBlock) {
						var parentArticle = videoBlock.closest('.movies-list article');
						var elInner = videoBlock.querySelector('.el-inner');
						var picture = videoBlock.querySelector('.inner-picture.cbo-picture-cover');
						var video;

						if (parentArticle) {
							parentArticle.addEventListener('mouseenter', function () {
								cursor.classList.add('visible');
							});
							parentArticle.addEventListener('mouseleave', function () {
								cursor.classList.remove('visible');
							});
						}

						if (elInner && picture) {
							elInner.addEventListener('mouseenter', function () {
								elInner.classList.add('is-hovered');
								if (!video) {
									video = document.createElement('video');
									video.muted = true;
									video.loop = true;
									video.playsInline = true;
									video.preload = 'metadata';
									video.classList.add('js-hover-video');
									var source = document.createElement('source');
									source.type = 'video/mp4';
									source.src = picture.getAttribute('data-video-url') || '';
									video.appendChild(source);
									picture.appendChild(video);
								}
								video.addEventListener('loadedmetadata', function () {
									video.currentTime = 0;
									video.play().catch(function (e) {
										console.warn('Autoplay bloqué :', e);
									});
								}, { once: true });
								if (video.readyState >= 1) {
									video.currentTime = 0;
									video.play().catch(function (e) {
										console.warn('Autoplay bloqué :', e);
									});
								}
							});

							elInner.addEventListener('mouseleave', function () {
								elInner.classList.remove('is-hovered');
								if (video) {
									video.pause();
									if (video.readyState >= 1) {
										video.currentTime = 0;
									}
								}
							});
						}
					});

					document.addEventListener('mousemove', function (e) {
						if (cursor.classList.contains('visible')) {
							cursor.style.left = e.clientX + 'px';
							cursor.style.top = e.clientY + 'px';
						}
					});
				}
			
				// ================================
				// Modales
				// ================================
				function cboInitModales(root) {
					root = root || document;
					var items = root.querySelectorAll('.movies-list .list-el');

					items.forEach(function (item) {
						item.addEventListener('click', function () {
							var modalId = this.getAttribute('data-modal-id');
							var modal = document.getElementById(modalId);
							if (modal) {
								modal.classList.add('modale--open');
								document.body.classList.add('body--hidden');
								var video = modal.querySelector('video');
								if (video) {
									video.currentTime = 0;
									video.muted = true;
									var playPromise = video.play();
									if (playPromise !== undefined) {
										playPromise
										.then(function () {
											var playPause = modal.querySelector('.playPause');
											var iconPlayer = playPause ? playPause.querySelector('i') : null;
											if (iconPlayer) {
												iconPlayer.classList.remove('icon--player');
												iconPlayer.classList.add('icon--pause');
											}
										})
										.catch(function (error) {
											console.warn('Autoplay refusé:', error);
										});
									}
								}
							}
						});
					});

					root.querySelectorAll('.modale-close').forEach(function (closeBtn) {
						closeBtn.addEventListener('click', function () {
							var modal = this.closest('.cbo-modale');
							if (modal) {
								modal.classList.remove('modale--open');
								document.body.classList.remove('body--hidden');
								var video = modal.querySelector('video');
								if (video) {
									video.pause();
								}
							}
						});
					});
			
					root.querySelectorAll('.playPause').forEach(function (playBtn) {
						playBtn.addEventListener('click', function () {
							var modaleInner = this.closest('.modale-inner');
							if (modaleInner) {
								modaleInner.classList.add('has-video-played');
							}
						});
					});
				}
			
				// ================================
				// Player vidéo personnalisé
				// ================================
				function cboInitCustomVideoPlayers(root) {
					root = root || document;
					var videoBlocks = root.querySelectorAll('.custom-video');
			
					videoBlocks.forEach(function (block) {
						if (block.dataset.initialized === "true") return;
						block.dataset.initialized = "true";
			
						var video = block.querySelector('video');
						var playPause = block.querySelector('.playPause');
						var seekBar = block.querySelector('.seekBar');
						var muteToggle = block.querySelector('.muteToggle');
						var fullscreenToggle = block.querySelector('.fullscreenToggle');
						var iconPlayer = playPause ? playPause.querySelector('i') : null;
						var iconVolume = muteToggle ? muteToggle.querySelector('i') : null;
			
						function updateSeekBarBackground(seekBar, value) {
							seekBar.style.background = 'linear-gradient(to right, #FFFF ' + value + '%, rgba(255,255,255, .5) ' + value + '%)';
						}
			
						if (playPause) {
							playPause.addEventListener('click', function () {
								if (video.paused) {
									video.play();
									if (iconPlayer) {
										iconPlayer.classList.remove('icon--player');
										iconPlayer.classList.add('icon--pause');
									}
								} else {
									video.pause();
									if (iconPlayer) {
										iconPlayer.classList.remove('icon--pause');
										iconPlayer.classList.add('icon--player');
									}
								}
							});
						}
			
						video.addEventListener('timeupdate', function () {
							if (video.duration > 0) {
								var value = (video.currentTime / video.duration) * 100;
								if (seekBar) {
									seekBar.value = value;
									updateSeekBarBackground(seekBar, value);
								}
							}
						});
			
						if (seekBar) {
							seekBar.addEventListener('input', function () {
								var value = seekBar.value;
								if (video.duration > 0) {
									video.currentTime = (value / 100) * video.duration;
									updateSeekBarBackground(seekBar, value);
								}
							});
						}
			
						if (muteToggle) {
							muteToggle.addEventListener('click', function () {
								video.muted = !video.muted;
								if (iconVolume) {
									if (video.muted) {
										iconVolume.classList.remove('icon--sound-on');
										iconVolume.classList.add('icon--sound-off');
									} else {
										iconVolume.classList.remove('icon--sound-off');
										iconVolume.classList.add('icon--sound-on');
									}
								}
							});
						}
			
						if (fullscreenToggle) {
							fullscreenToggle.addEventListener('click', function () {
								if (!document.fullscreenElement) {
									video.requestFullscreen();
								} else {
									document.exitFullscreen();
								}
							});
						}
					});
				}
			
				// ================================
				// Fonction d’initialisation commune après AJAX
				// ================================
				function cboReinitAll(root) {
					cboInitHoverEffects(root);
					cboInitModales(root);
					cboInitCustomVideoPlayers(root);
					if (typeof applyLastNameEffect === 'function') applyLastNameEffect();
					if (typeof applyVideoEffect === 'function') applyVideoEffect();
				}
			
				// ================================
				// Scroll infini & filtres
				// ================================
				var moviesSection = document.getElementById('cbo-movies');
				if (!moviesSection) return;
			
				var currentPage = 1;
				var maxPage = parseInt(moviesSection.getAttribute('data-max-page'), 10);
				var isLoading = false;
				var currentCategory = 'tous';
				var moviesList = moviesSection.querySelector('.movies-list');
			
				function loadMoreMovies() {
					if (isLoading || currentPage >= maxPage) return;
			
					isLoading = true;
					currentPage++;
			
					var xhr = new XMLHttpRequest();
					xhr.open('POST', cbo_ajax_object.ajax_url, true);
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			
					xhr.onload = function () {
						if (xhr.status === 200) {
							var response = JSON.parse(xhr.responseText);
							if (response.success) {
								var tempDiv = document.createElement('div');
								tempDiv.innerHTML = response.data.content;
								while (tempDiv.firstChild) {
									moviesList.appendChild(tempDiv.firstChild);
								}
								maxPage = response.data.max_page;
								cboReinitAll(moviesList);
							}
						}
						isLoading = false;
					};
			
					xhr.onerror = function () {
						console.error('Erreur AJAX');
						isLoading = false;
					};
			
					xhr.send(
						'action=cbo_load_more_movies' +
						'&page=' + currentPage +
						'&nonce=' + cbo_ajax_object.nonce +
						'&category_slug=' + currentCategory
					);
				}
			
				if (moviesSection && moviesList) {
					window.addEventListener('scroll', function () {
						var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
						var windowHeight = window.innerHeight;
						var listBottom = moviesSection.offsetTop + moviesList.offsetHeight;
				
						if (scrollTop + windowHeight >= listBottom - 100) {
							loadMoreMovies();
						}
					});
				}
			
				// ================================
				// Filtres AJAX avec fade
				// ================================
				if (document.querySelector('.cbo-filters')) {
					var links = document.querySelectorAll('.tags-list a');
					var filters = document.querySelector('.cbo-filters');
					var postType = filters.getAttribute('data-post-type');
					var container = document.querySelector('.' + postType + '-list');
					var archiveLink = filters.querySelector('.tags-list a[data-archive="1"]');
					var archiveSlug = archiveLink ? archiveLink.getAttribute('href').split('/').filter(Boolean).pop() : '';
			
					function fadeOut(el, duration, callback) {
						el.style.transition = 'opacity ' + duration + 'ms';
						el.style.opacity = 0;
						setTimeout(callback, duration);
					}
			
					function fadeIn(el, duration) {
						el.style.transition = 'opacity ' + duration + 'ms';
						el.style.opacity = 1;
					}
			
					links.forEach(function (link) {
						link.addEventListener('click', function (e) {
							e.preventDefault();
			
							var href = this.getAttribute('href');
							var parts = href.split('/').filter(Boolean);
							var slug = parts.pop();
							if (slug === archiveSlug) slug = 'tous';
			
							currentCategory = slug;
							currentPage = 1;
			
							fadeOut(container, 300, function () {
								var xhr = new XMLHttpRequest();
								xhr.open('POST', cbo_ajax_object.ajax_url, true);
								xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			
								xhr.onload = function () {
									if (xhr.status === 200) {
										var response = JSON.parse(xhr.responseText);
										if (response.success) {
											container.innerHTML = response.data.content;
											maxPage = response.data.max_page;
											fadeIn(container, 300);
											links.forEach(function (el) {
												el.classList.remove('el--active');
											});
											link.classList.add('el--active');
											cboReinitAll(container);
										}
									}
								};
			
								xhr.send(
									'action=cbo_load_more_movies' +
									'&page=1' +
									'&nonce=' + cbo_ajax_object.nonce +
									'&category_slug=' + currentCategory
								);
							});
						});
					});
				}
			
				// Initialisation initiale
				cboReinitAll();
			})();


			/////////////////// PARALLAX PICTURE ///////////////////
			function updateParallax() {
				var images = document.querySelectorAll('.parallax-img');
				var windowHeight = window.innerHeight;

				images.forEach(function(image) {
				  var rect = image.getBoundingClientRect();

				  if (rect.bottom > 0 && rect.top < windowHeight) {
					var scrollProgress = 1 - rect.top / windowHeight;
					var offset = scrollProgress * 50;
					image.style.transform = 'translateY(' + offset + 'px)';
				  } else {
					image.style.transform = 'translateY(0)';
				  }
				});
			}
			window.addEventListener('scroll', updateParallax);
			window.addEventListener('resize', updateParallax);
			updateParallax();


			/////////////////// RELATIONSHIP SLIDER ///////////////////
			$('.cbo-relationship .relationship-list').slick({
				arrows : true,
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: false,
				speed: 300,
				infinite: false,
			});

			
			//////////////// SCROLL ANIMATIONS ////////////////
			var scroll = window.requestAnimationFrame || function(callback){ window.setTimeout(callback, 1000/60)};
			var elementsToShow = document.querySelectorAll('.slide-up, .slide-up, .slide-right, .slide-left, .scale-up, .scale-down'); 
			function loop() {
				Array.prototype.forEach.call(elementsToShow, function(element){
					if (isElementInViewport(element)) {
						element.classList.add('anim-scroll');
					} else {
						element.classList.remove('anim-scroll');
					}
				});
				scroll(loop);
			}	
			loop();
			function isElementInViewport(el) {
				if (typeof jQuery === "function" && el instanceof jQuery) {
					el = el[0];
				}
				var rect = el.getBoundingClientRect();
				return (
					(rect.top <= 0&& rect.bottom >= 0)||(rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) && rect.top <= (window.innerHeight || document.documentElement.clientHeight))||(rect.top >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
				);
			}
		},
			
		onload : function(){},
		onresize : function(){},
		onscroll : function(){},
	};
	$(document).ready( function(){
		Master.onready();
	});

	$(window).load( function(){
		Master.onload();
	});

	$(window).resize( function(){
		Master.onresize();
	});

	$(window).on('scroll', function(){
		Master.onscroll();
	});

})(jQuery);
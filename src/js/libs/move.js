// Cœur sur David
var cg_Move = {

	init_wavy : function(){

        function createWordsAndLetters( string, wordsOnly ){
            var words = string.split(' ')
            for( var i = 0, len = words.length; i < len; i++ ) {
                var text = words[i].trim()
                if(text !== '' && typeof text == 'string'){

                    if(!wordsOnly)
                        text = (text == '')? text : text.replace(/\S/g, "<span class='letter'>$&</span>")
                    
                    words[i] = '<span class="word">' + text + '</span>'
                }
            }
            return words.join(' ')
        }

        // Shortcut

        $('.cg-wavy').each( function(){
            if( $(this).find('.wavy-letters').get().length == 0 ){

                $(this).wrapInner('<span class="wavy-inner"></span>')
                       .wrapInner('<span class="wavy-letters"></span>')
            }
        });

        // Init

        $('.cg-wavy .wavy-letters .wavy-inner').each( function(){

            if($(this).find('.letter').get().length == 0){

                var $html = $(this)
                var $p = $(this).closest('.cg-wavy')
                var wordsOnly = $p.hasClass('wavy--words')

                // On traite les balises html

                var $markup = $html.find('*')
                $markup.each( function(){
                    var text = $(this).text()
                    $(this).html( createWordsAndLetters( text, wordsOnly ) )
                })

                // On affiche le premier terme

                var i_term = 0
                var $terms = $markup.find('.term')
                $terms.each( function(){
                    if(i_term == 0) $(this).addClass('active')
                    i_term++
                })

                // On traite les autres mots

                var $words = $html.contents().filter( function() {
                    return this.nodeType === 3;
                })
                $words.each( function(){
                    var text = $(this).text()
                    var markup = createWordsAndLetters( text, wordsOnly )
                    $html.html( $html.html().replace( text, markup ) )
                })

                // Il est prêt

                $p.addClass('wavy--ready');

                // On affiche le texte à animer

                $html.addClass('active')
            }

            cg_Move.resize_wavy( $(this) )
        });
    },

    resize_wavy : function( $obj ){

        if(typeof $obj == 'undefined')
            $obj = $('.cg-wavy .wavy-letters .wavy-inner')

        $obj.each( function(){

            var $terms = $(this).find('.term')
            var $active = $terms.filter('.active')
            var $longestTerm = false
            var maxLength = 0
            
            $terms.each( function(){

                var $letters = $(this).find('.letter')
                var nbLetters = $letters.get().length
                
                if(nbLetters > maxLength){
                    maxLength = nbLetters
                    $longestTerm = $(this)
                }
            })

            if($longestTerm){
             
                $active.css('display','none');
                $longestTerm.css('display','inline');

                $(this).attr('style', '').css({
                    width:$(this).outerWidth(),
                    height:$(this).outerHeight()
                })

                $longestTerm.attr('style','')
                $active.attr('style','')
            }
        })
    },

    anime_wavy_timeouts : [],
    anime_wavy : function( obj, wordsOnly ){

        if(wordsOnly){

            var $words = $(obj).find('.word').not($(obj).find('.term'))
            $words = $words.toArray()

            if( $words.length > 0 ){

                $(obj).addClass('cg-wavy-animate');

                anime({
                    targets: $words,
                    translateY: ["1em", 0],
                    translateZ: 0,
                    opacity: [0, 1],
                    duration: 1500,
                    easing: "easeOutExpo",
                    delay: function(el, i){
                        return 50 * i
                    } 
                });
            }
        }

        else{

            var $letters = $(obj).find('.letter').not($(obj).find('.term .letter'))
            $letters = $letters.toArray()

            if( $letters.length > 0 ){

                $(obj).addClass('cg-wavy-animate');

                anime({
                    targets: $letters,
                    translateY: ["1em", 0],
                    translateZ: 0,
                    rotateZ: [0, 0],
                    opacity: [0, 1],
                    duration: 750,
                    easing: "easeOutExpo",
                    delay: function(el, i){
                        return 20 * i
                    },
                    update: function(anim) {
                        if(Math.round(anim.progress) == 100)
                            animeTerms(obj)
                    }       
                });
            }
        }

        function animeTerms( obj, index ){

            var terms = obj[0].querySelectorAll('.term')
            if(terms.length > 0){

                // On trouve l'index du précédent terme
                // et on le fait disparaitre

                var before = false
                if(typeof(index) == 'undefined'){
                    index = 0
                }
                else{
                    before = index - 1
                    if(before < 0)
                        before = terms.length - 1

                    terms[before].classList.remove('active')
                }

                // On trouve le suivant

                var active = terms[0]
                if(terms[index])
                    active = terms[index]
                else
                    index = 0
                
                active.classList.add('active')
                var letters = active.querySelectorAll('.letter')
                               
                // Puis on le fait apparaitre

                anime({
                    targets: letters,
                    translateY: ["0.8em", 0],
                    translateX: ["0.35em", 0],
                    translateZ: 0,
                    rotateZ: [45, 0],
                    duration: 500,
                    easing: "easeOutExpo",
                    delay: function(el, i){
                        return 30 * i
                    },
                    update: function(anim) {
                        if(Math.round(anim.progress) == 100){
                         
                            if(cg_Move.anime_wavy_timeouts[ obj ])
                                clearTimeout(cg_Move.anime_wavy_timeouts[ obj ]);
                         
                            cg_Move.anime_wavy_timeouts[ obj ] = setTimeout( function(){
                                animeTerms(obj, index+1)
                            }, 5000)
                        }
                    }
                })
            }
        }
    },

    
    scroll_slides : function(){

        var animations = [
            {
                selector: '.cg-wavy',
                class: 'cg-wavy-animate'
            }
        ];

        var win_top = $(window).scrollTop();
        var win_height = $(window).height();
        var win_width = $(window).width();
        var min_width_delay = 768;
        var coeff = .8;

        $.each( animations, function( i, animation ){

            $( animation.selector ).each(function(){

                var $el = $(this);
                if( !$el.hasClass( animation.class ) ){

                    var pos = $el.offset().top;

                    if (pos < win_top + (win_height*coeff) && pos >= win_top-win_height) {

                        var group = $el.attr('data-group');
                        var group_animation = $el.attr('data-anim');
                        var reverse = $el.attr('data-reverse');
                        var delay = parseInt( $el.attr('data-delay') );

                        if(isNaN(delay) || win_width < min_width_delay){ 
                            delay = 0;
                        }

                        if( animation.selector == '.group-effect' ){

                            var $group_els = $el.find( group );
                            var group_index = reverse ? $group_els.get().length-1 : 0;
                            var group_delay = 0;
                            
                            function animateGroupElement(){

                                var $group_el = $group_els.eq( group_index );                                
                                if( $group_el.get().length > 0 ){

                                    setTimeout( function(){ 
                                        $group_el.addClass( findAnimationClass('.'+group_animation) );
                                        group_index += reverse ? -1 : 1;
                                        animateGroupElement();
                                    }, delay);
                                }
                                else{
                                    setTimeout( function(){ 
                                        $el.addClass( animation.class );
                                    }, delay);
                                }
                            }

                            function findAnimationClass( selector ){

                                var result = animations.filter( function(obj){
                                  return obj.selector === selector
                                })

                                return result[0].class;
                            }

                            animateGroupElement();

                        }

                        else if( animation.selector == '.cg-wavy' ){
                            var wordsOnly = ($el.hasClass('wavy--words')) ? true : false;
                            cg_Move.anime_wavy( $el, wordsOnly );
                        }

                        else if( typeof $el.parent().attr('data-group') == 'undefined' ){

                            setTimeout( function(){ 
                                $el.addClass( animation.class );
                            }, delay);
                        }
                    }
                }
            });
        });
    }
}
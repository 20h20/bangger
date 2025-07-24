/* 
 * Author : David Essayan (da.essayan@gmail.com)
 * License : Private
*/

var CBO_Smoothscroll = {

    options: {                
        class : '.cbo-smoothscroll', 
        inertia : 20,             
        speed: 150,
        frameRate: 10,            
    },

    init: function( opts ){
        this.options = Object.assign({}, this.options, opts);
        this.set_event_listener();
    },

    set_event_listener: function(){
        (function(self) {
            var mousewheelevt=(/Firefox/i.test(navigator.userAgent))? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
            document.addEventListener(mousewheelevt, function(e) {self.smooth(e)}, {passive:false});
        })(this);
    },

    destroy: function() {
        window.removeEventListener('DOMMouseScroll', this.smooth)
        clearInterval(interval)
    },

    smooth: function(event) {
        var target = event.target
        target = target && $(target).parents(CBO_Smoothscroll.options.class)[0]
        if (target)
            return true

        var delta = 0
        if (event.wheelDelta) {
            delta = event.wheelDelta / 120
        } else if (event.detail) {
            delta = -event.detail / 3
        }

        this.handle(delta)
        if (event.preventDefault) event.preventDefault()
        event.returnValue = false
    },

    scroll_up: true,
    scroll_end: null,
    scroll_interval: null,

    handle: function(delta) {

        var self = CBO_Smoothscroll,
            interval = self.options.frameRate,  
            intertia = self.options.inertia, 
            speed = self.options.speed

        self.scroll_end = (self.scroll_end == null) ? $(window).scrollTop() : self.scroll_end
        self.scroll_end -= speed * delta
        self.scroll_up = delta > 0

        if (self.scroll_interval == null) {
            self.scroll_interval = setInterval(function () {
                
                var scrollTop = $(window).scrollTop();
                var step = Math.round((self.scroll_end - scrollTop) / intertia);
                if (scrollTop <= 0 || scrollTop >= $(window).prop("scrollHeight") - $(window).height() || self.scroll_up && step > -1 || !self.scroll_up && step < 1 ) {
                    clearInterval(self.scroll_interval)
                    self.scroll_interval = null
                    self.scroll_end = null
                }
                $(window).scrollTop(scrollTop + step );
            }, interval);
        }
    }
}
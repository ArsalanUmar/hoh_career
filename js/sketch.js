(function() {
    var t, o, e = [].slice;
    (t = jQuery).fn.sketch = function() {
        var i, n, s;
        return n = arguments[0], i = 2 <= arguments.length ? e.call(arguments, 1) : [], this.length > 1 && t.error("Sketch.js can only be called on one element at a time."), s = this.data("sketch"), "string" == typeof n && s ? s[n] ? "function" == typeof s[n] ? s[n].apply(s, i) : 0 === i.length ? s[n] : 1 === i.length ? s[n] = i[0] : void 0 : t.error("Sketch.js did not recognize the given command.") : s || (this.data("sketch", new o(this.get(0), n)), this)
    }, o = function() {
        function o(o, e) {
            this.el = o, this.canvas = t(o), this.context = o.getContext("2d"), this.options = t.extend({
                toolLinks: !0,
                defaultTool: "marker",
                defaultColor: "#000000",
                defaultSize: 5
            }, e), this.painting = !1, this.color = this.options.defaultColor, this.size = this.options.defaultSize, this.tool = this.options.defaultTool, this.actions = [], this.action = [], this.canvas.bind("click mousedown mouseup mousemove mouseleave mouseout touchstart touchmove touchend touchcancel", this.onEvent), this.options.toolLinks && t("body").delegate('a[href="#' + this.canvas.attr("id") + '"]', "click", function(o) {
                var e, i, n, s, a, h;
                for (e = t(this), n = t(e.attr("href")).data("sketch"), s = 0, a = (h = ["color", "size", "tool"]).length; s < a; s++) i = h[s], e.attr("data-" + i) && n.set(i, t(this).attr("data-" + i));
                return t(this).attr("data-download") && n.download(t(this).attr("data-download")), !1
            })
        }
        return o.prototype.download = function(t) {
            var o;
            return t || (t = "png"), "jpg" === t && (t = "jpeg"), o = "image/" + t, window.open(this.el.toDataURL(o))
        }, o.prototype.set = function(t, o) {
            return this[t] = o, this.canvas.trigger("sketch.change" + t, o)
        }, o.prototype.startPainting = function() {
            return this.painting = !0, this.action = {
                tool: this.tool,
                color: this.color,
                size: parseFloat(this.size),
                events: []
            }
        }, o.prototype.stopPainting = function() {
            return this.action && this.actions.push(this.action), this.painting = !1, this.action = null, this.redraw()
        }, o.prototype.onEvent = function(o) {
            return o.originalEvent && o.originalEvent.targetTouches && (o.pageX = (o.originalEvent.targetTouches[0] !== undefined && o.originalEvent.targetTouches[0].pageX !== undefined)  ? o.originalEvent.targetTouches[0].pageX : 0, o.pageY = (o.originalEvent.targetTouches[0] !== undefined && o.originalEvent.targetTouches[0].pageX !== undefined)  ? o.originalEvent.targetTouches[0].pageY:0), t.sketch.tools[t(this).data("sketch").tool].onEvent.call(t(this).data("sketch"), o), o.preventDefault(), !1
        }, o.prototype.redraw = function() {
            var o;
            if (this.el.width = this.canvas.width(), this.context = this.el.getContext("2d"), o = this, t.each(this.actions, function() {
                    if (this.tool) return t.sketch.tools[this.tool].draw.call(o, this)
                }), this.painting && this.action) return t.sketch.tools[this.action.tool].draw.call(o, this.action)
        }, o
    }(), t.sketch = {
        tools: {}
    }, t.sketch.tools.marker = {
        onEvent: function(t) {
            switch (t.type) {
                case "mousedown":
                case "touchstart":
                    this.painting && this.stopPainting(), this.startPainting();
                    break;
                case "mouseup":
                case "mouseout":
                case "mouseleave":
                case "touchend":
                case "touchcancel":
                    this.stopPainting()
            }
            if (this.painting) return this.action.events.push({
                x: t.pageX - this.canvas.offset().left,
                y: t.pageY - this.canvas.offset().top,
                event: t.type
            }), this.redraw()
        },
        draw: function(t) {
            var o, e, i, n;
            for (this.context.lineJoin = "round", this.context.lineCap = "round", this.context.beginPath(), this.context.moveTo(t.events[0].x, t.events[0].y), e = 0, i = (n = t.events).length; e < i; e++) o = n[e], this.context.lineTo(o.x, o.y);
            return this.context.strokeStyle = t.color, this.context.lineWidth = t.size, this.context.stroke()
        }
    }, t.sketch.tools.eraser = {
        onEvent: function(o) {
            return t.sketch.tools.marker.onEvent.call(this, o)
        },
        draw: function(o) {
            var e;
            return e = this.context.globalCompositeOperation, this.context.globalCompositeOperation = "destination-out", o.color = "rgba(0,0,0,1)", t.sketch.tools.marker.draw.call(this, o), this.context.globalCompositeOperation = e
        }
    }
}).call(this);
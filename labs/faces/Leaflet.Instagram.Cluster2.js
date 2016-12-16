/*! Leaflet.Instagram 2014-06-26 */
L.Instagram = L.FeatureGroup.extend({
    options: {
        icon: {
            iconSize: [40, 40],
            className: "leaflet-marker-instagram"
        },
        popup: {
            className: "leaflet-popup-instagram"
        },
        imageTemplate: '<div class="pgpicholder"><a href="{link}" target="_blank" title="View this photo"><img style="height:calc({height}px/2); width:calc({width}px/2);" src="{image_standard}"/ ></a><div class="pgtextholder"><p style="font-weight:bold;">{pname} &mdash; {year}</p><p>{caption}</a></p></div>',
        onClick: function(a) {
            var b = a.layer.image,
                c = this.options,
                d = c.imageTemplate;
            a.layer.bindPopup(L.Util.template(d, b), c.popup).openPopup()
        }
    },
    initialize: function(a, b) {
        this._url = a, b = L.setOptions(this, b), L.FeatureGroup.prototype.initialize.call(this), b.onClick && this.on("click", b.onClick, this)
    },
    onAdd: function(a) {
        this.load(), L.FeatureGroup.prototype.onAdd.call(this, a)
        	
    },
    load: function(a) {
        var b = this;
        return reqwest({
            url: a || this._url,
            type: "jsonp",
            success: function(a) {
                b._parse(a.data || a.rows || []), b.fire("load", {
                    data: a
                }
                );
				$( '.pgslides' ).cycle();
					
               
            }
        }), this
    },
    _parse: function(a) {
        for (var b = 0, c = a.length; c > b; b++) {
            var d = a[b];
            d.images ? d.location && (this.options.filter ? d.tags && -1 !== d.tags.indexOf(this.options.filter) && this.addLayer(this._parseImage(d)) : this.addLayer(this._parseImage(d))) : this.addLayer(d)
        }
        return this
    },
    _parseImage: function(a) {
        return {
            latitude: a.location.latitude,
            longitude: a.location.longitude,
            image_thumb: a.images.thumbnail.url,
            image_standard: a.images.standard_resolution.url,
            caption: a.caption ? a.caption.text : "",
            type: a.type,
            link: a.link
        }
    },
    addLayer: function(a) {
        var b = L.marker([a.latitude, a.longitude], {
            icon: L.icon(L.extend({
                iconUrl: a.image_thumb
            }, this.options.icon)),
            title: a.caption || ""
        });
        b.image = a, L.FeatureGroup.prototype.addLayer.call(this, b)
        
    }
}), L.instagram = function(a, b) {

    return new L.Instagram(a, b)
}, L.Instagram.Cluster = L.MarkerClusterGroup.extend({
    options: {
        featureGroup: L.instagram,
        maxClusterRadius: 40,
        spiderfyDistanceMultiplier: 1.5,
        showCoverageOnHover: !1,
        iconCreateFunction: function(a) {
	        	var c = [];
	        	var thethumblist = [];
	        var thumblist = a.getAllChildMarkers().length;
				for (var i = 0; (i < thumblist && i < 3); i++) {
				    c[i] = a.getAllChildMarkers()[i].image.image_thumb;
				    thethumblist += '<img src="' + c[i] + '">';
				};
					

            return new L.DivIcon({
                className: "leaflet-cluster-instagram",
                html: '<div class="pgslides">' + thethumblist + '</div><b>' + a.getChildCount() + "</b>"
            })
        }
    },
    initialize: function(a, b) {
        b = L.Util.setOptions(this, b), L.MarkerClusterGroup.prototype.initialize.call(this), this._instagram = b.featureGroup(a, b)
    },
    onAdd: function() {
        this._instagram.load().on("load", this._onLoad, this);
        
        
    },
    _onLoad: function(a) {
        this.addLayer(this._instagram._parse(a.data || a.rows || [])), L.MarkerClusterGroup.prototype.onAdd.call(this, map)
            
    }
}), L.instagram.cluster = function(a, b) {
    return new L.Instagram.Cluster(a, b)
    
	
};
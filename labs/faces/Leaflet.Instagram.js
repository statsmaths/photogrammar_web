

L.Instagram = L.FeatureGroup.extend({
	options: {
		icon: {						
			iconSize: [40, 40],
			className: 'leaflet-marker-instagram'
		},
		popup: {
			className: 'leaflet-popup-instagram'
		},		
		template: '<a href="{link}" target="_blank" title="View this photo"><img src="{image_standard}"/ height="' + hforimg +'" width="' + wforimg + '"></a><p style="font-weight:bold;">{pname}</p><p>{caption}</a></p>',
		
		onClick: function(evt) {
			
			var imgforsize = new Image();
			imgforsize.src = L.Util.template('{image_standard}', image);
			imgforsize.onload = function (){
				var hforimg =  this.height;
				var wforimg =  this.width;
				alert(this.width + 'x' + this.height);
				
			}

			
			var image    = evt.layer.image,
			    options  = this.options;
			    
			
						evt.layer.bindPopup(L.Util.template(options.template, image), options.popup).openPopup();

			
		}
	},

	initialize: function (url, options) {	
		this._url = url;
		options = L.setOptions(this, options);
		L.FeatureGroup.prototype.initialize.call(this);
		if (options.onClick) {
			this.on('click', options.onClick, this);
		}
	},

	onAdd: function (map) {
		this.load();
		L.FeatureGroup.prototype.onAdd.call(this, map);
	},

	load: function (url) {
		var self = this;
		reqwest({
			url: url || this._url,
			type: 'jsonp', 
			success: function (data) {
				self._parse(data.data || data.rows || []);
				self.fire('load', { data: data });
			}
		});
		return this;
	},

	_parse: function (images) {
		for (var i = 0, len = images.length; i < len; i++) {
			var image = images[i];
			this.addLayer(image);
			
		}
		return this;
	},

	// Simplify image format from Instagram API
	_parseImage: function (image) {
		return {
			latitude:       image.location.latitude,
			longitude:      image.location.longitude,
			image_thumb:    image.images.thumbnail.url,
			image_standard: image.images.standard_resolution.url,
			caption:        (image.caption) ? image.caption.text : '',
			type: 			image.type,			
			link: 			image.link
		};
	},

	addLayer: function (image) {	
		var marker = L.marker([image.latitude, image.longitude], {
			icon: L.icon(L.extend({
				iconUrl: image.image_thumb		
			}, this.options.icon)),
			title: image.caption || ''
		});		
		marker.image = image;
		L.FeatureGroup.prototype.addLayer.call(this, marker);
	}
});

L.instagram = function (url, options) {
	return new L.Instagram(url, options);
};
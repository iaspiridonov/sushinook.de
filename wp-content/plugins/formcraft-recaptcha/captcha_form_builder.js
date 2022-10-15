FormCraftApp.controller('CaptchaController', function($scope, $http) {
	$scope.$watchCollection('Addons', function(newCol, oldCol, scope) {
		if (typeof $scope.$parent.Addons!='undefined' && typeof $scope.$parent.addField!='undefined') {
			$scope.$parent.addField.others.push({
				name: 'reCaptcha',
				fieldHTMLTemplate: "<div data-site-key='{{Addons.Captcha.site_key}}' class='captcha-placeholder'>reCaptcha v3</div><input type='hidden' class='recaptcha-token' name='recaptcha-token'/>",
				fieldOptionTemplate: "<label class='w-3'><span>Width</span><input type='text' ng-model='element.elementDefaults.field_width'><i data-html='true' tooltip data-placement='top' data-toggle='tooltip' title='Set the widths of two fields to <Strong>50%</strong> each to fit them in one row.<br>You can have any number of fields in the same row, as long as the sum of widths is <strong>100%</strong>' class='formcraft-icon tooltip-icon'>info_outline</i></label>Go to Addons -> reCaptcha to add your Site Key and Secret Key.",
				defaults: {
					main_label: 'Captcha',
					sub_label: 'captcha',
				}
			});
		}
	});
});
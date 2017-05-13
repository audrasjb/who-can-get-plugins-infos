(function() {
	tinymce.PluginManager.add( 'tinymce_wcgpi_theme_class', function( editor, url ) {
		// themes : Add Button to Visual Editor Toolbar
		editor.addButton('tinymce_wcgpi_theme_class', {
			title: wcgpiTranslations['wcgpi_add_button_theme'],
			id: 'mce-wp-wcgpi-theme',
			stateSelector: 'wcgpi',
			onclick: function() {
				editor.windowManager.open({
					title: wcgpiTranslations['wcgpi_modal_title_theme'],
					body: [
						{
							type: 'listbox',
							name: 'themeType',
							label: wcgpiTranslations['wcgpi_type_label_theme'],
							tooltip: wcgpiTranslations['wcgpi_type_help_theme'],
							values: [
								{text: wcgpiTranslations['wcgpi_type_wporg_theme'], value: 'wporg'}, 
								{text: wcgpiTranslations['wcgpi_type_envato_theme'], value: 'envato'}, 
							]
						},{
							type: 'textbox',
							name: 'themeID',
							label: wcgpiTranslations['wcgpi_theme_id_theme'],
							tooltip: wcgpiTranslations['wcgpi_theme_id_help_theme'],
							minWidth: 300
						}],
					onsubmit: function( e ) {
						editor.insertContent( 
							'[themeinfos type="' + e.data.themeType + '" theme_id="' + e.data.themeID + '"]' 
						);
					}
				});				
			}
		});		

	});
})();
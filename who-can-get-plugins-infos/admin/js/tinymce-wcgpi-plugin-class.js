(function() {
	tinymce.PluginManager.add( 'tinymce_wcgpi_plugin_class', function( editor, url ) {
		// Plugins : Add Button to Visual Editor Toolbar
		editor.addButton('tinymce_wcgpi_plugin_class', {
			title: wcgpiTranslations['wcgpi_add_button_plugin'],
			id: 'mce-wp-wcgpi-plugin',
			stateSelector: 'wcgpi',
			onclick: function() {
				editor.windowManager.open({
					title: wcgpiTranslations['wcgpi_modal_title_plugin'],
					body: [
						{
							type: 'listbox',
							name: 'pluginType',
							label: wcgpiTranslations['wcgpi_type_label_plugin'],
							tooltip: wcgpiTranslations['wcgpi_type_help_plugin'],
							values: [
								{text: wcgpiTranslations['wcgpi_type_wporg_plugin'], value: 'wporg'}, 
								{text: wcgpiTranslations['wcgpi_type_envato_plugin'], value: 'envato'}, 
							]
						},{
							type: 'textbox',
							name: 'pluginID',
							label: wcgpiTranslations['wcgpi_plugin_id_plugin'],
							tooltip: wcgpiTranslations['wcgpi_plugin_id_help_plugin'],
							minWidth: 300
						}],
					onsubmit: function( e ) {
						editor.insertContent( 
							'[plugininfos type="' + e.data.pluginType + '" plugin_id="' + e.data.pluginID + '"]' 
						);
					}
				});				
			}
		});		

	});
})();
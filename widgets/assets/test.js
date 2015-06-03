SirTrevor.Blocks.Widget = SirTrevor.Block
		.extend({

			type : "widget",

			title : function() {
				return 'Widget';
			},

			editorHTML : 'Classname: <input type=text class="js-classname" name="className"> Mode: <input type=text class="js-mode" name="mode"> Settings: <input type=hidden class="js-settings" name="settings"> <div class="js-container" name="settings"></div> ',

			icon_name : 'quote',
			
		    onBlockRender: function(){
			    container = this.$('.js-container');
			    editor = container.data('editor');
			    if(editor == null) {
					editor = new JSONEditor(container[0]);
					container.data('editor', editor);
			    }
		    },
		    
			loadData: function(data) {
				if (data != null) {
					this.$('.js-mode').val(data.mode);
					this.$('.js-classname').val(data.className);
					this.$('.js-settings').val(data.settings);
				    container = this.$('.js-container');
				    editor = container.data('editor');
				    if(editor == null) {
						editor = new JSONEditor(container[0]);
						container.data('editor', editor);
				    }
				    editor.set($.parseJSON(data.settings));
				}

			},

		});
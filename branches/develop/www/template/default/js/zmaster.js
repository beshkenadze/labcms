/**
 * @author akira
 */

function focusPokus(){
		var auth = $$(".focusPokus");
		auth.each( function(el){
				if(el.type=="text"){
					var oldValue = el.value;
					el.addEvent('focus', function() {
						el.value = "";
					});
					el.addEvent('blur', function() {
						var newValue = el.value;
						if(newValue == "") {
							el.value = oldValue;
						}
					});
				}				
			});
		}

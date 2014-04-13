$(EditLanguage);

function EditLanguage()
{
	var languageObject = $("[name='language']");
	languageObject.change(listCountries);
	
	if(selected_language_abbr != "no_language")
		languageObject.val(selected_language_abbr).change();
	
	$("#country").change(function(){
		$.ajax({
			type:"post",
			url:"admin.php?page=edit_language",
			data:"admin_action=get_date_format&locale=" + $("[name='language']").val() + "_" + $("#country").val(),
			dataType:"json",
			success:function(response){
				if(response.success === true)
				{
					$("#date_format").val(response.format);
				}
				else
				{
                    MESSAGEBOX.showMessage(GT.HATA_OLUSTU, GT.BEKLENMEDIK_HATA, messageType.ERROR, [{"name":GT.TAMAM}]);
				}
			},
			error: function(){
                MESSAGEBOX.showMessage(GT.HATA_OLUSTU, GT.BEKLENMEDIK_HATA, messageType.ERROR, [{"name":GT.TAMAM}]);
			}
		});
	});
}

function listCountries()
{
	$.ajax({
		type:"post",
		data:"admin_action=l_c_b_l&language=" + $("[name='language']").val(),
		dataType:"json",
		success:function(response){
			var length = response.length;
			var cHtml = "";
			var l = null;
			
			for(var i=0; i<length; i++)
			{
				l = response[i];
				cHtml += '<option value="' + l.country_abbr + '" ';
				if(selected_country_abbr != "no_country")
					cHtml += selected_country_abbr == l.country_abbr ? ' selected="true" ' : "";
				cHtml += '>' + l.country_name + '</option>';
			}
			
			$("[name='country']").html(cHtml).trigger("change");
		},
		error:function(){
            MESSAGEBOX.showMessage(GT.HATA_OLUSTU, GT.BEKLENMEDIK_HATA, messageType.ERROR, [{"name":GT.TAMAM}]);
		},
		complete: function(){
			
		}
		
	});
}
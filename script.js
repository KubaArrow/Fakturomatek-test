var il_d=1;


function add()
{
    il_d++;
    $("#il_tow").val(il_d);
   // $("#il_tow").val(parseInt($("#il_tow").val())+1);
    $("#next_tw").replaceWith(' <table style="margin:0 20px; width:1040px;" id="T'+il_d+'"><tr><td class=" td6"><input class="td" name="tw['+il_d+']"></td><td class=" td'+il_d+'"><input type="number" min="1" class="td" name="ilo['+il_d+']"></td><td class=" td1"><input list="JM" class="td" name="jm['+il_d+']"></td><td class=" td1"><input list="VAT" class="td" name="vat['+il_d+']"></td><td class=" td1"><input type="number" step="0.01" min="0" class="td" name="cena['+il_d+']"></td><td class=" td1"> <i onclick="del_tow('+il_d+')" class="tr-button far fa-trash-alt"></i></td></tr></table><div id="next_tw"></div>');
}
function del_tow(id)
{
   // $("#il_tow").val($("#il_tow").val()-1);
    $("#T"+id).remove();
}

function uzupel(nr)
{
    console.log(nr);
    switch (nr)
    {
        case 1:  var nr_fak=d.getFullYear()+'/'+mies+'/'+d.getDate()+'/'+Math.floor((Math.random() * 900) + 100); $("#nr_fak").val(nr_fak);break;
        case 2: $("#data_wys").val(adate);break;
        case 3: $("#miej").val(miej);break;
        case 4: $("#data_wyk").val(adate);break;
        case 5: $("#nazwa").val(nazwa);$("#adres").val(adres);$("#nip").val(nip);break;
    }
}
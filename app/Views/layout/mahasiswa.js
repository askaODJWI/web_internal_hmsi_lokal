$("#cek").click(function(e) {
    e.preventDefault();
    let div = $(".hasil_cek");
    let error = $(".hasil_error");
    let cek_nrp = $("#cek_nrp");
    let cek_prodi = $("#cek_prodi");
    let cek_nama = $("#cek_nama");
    let cek_angkatan = $("#cek_angkatan");
    let data_benar = $("#data_benar");
    let nrp_salah = $("#nrp_salah");
    let form_nrp = $("#form_nrp");
    let form2_nrp = $("#form2_nrp");
    let nrp = $("#nrp").val();

    div.hide();
    error.hide();

    if(nrp.length === 10 || nrp.length === 14)
    {
        cek_nrp.empty();
        cek_prodi.empty();
        cek_nama.empty();
        cek_angkatan.empty();
        nrp_salah.empty();
        data_benar.prop('checked',false);
        $("#cek").prop('disabled',true);

        $.ajax(
            {
                type: "GET",
                url: "/ajax/cek_nrp/" + nrp,
                dataType: "json",

                success: function (data)
                {
                    console.log(data);
                    cek_nrp.append(data["nrp"]);
                    cek_nama.append(data["nama"]);
                    cek_prodi.append(data["prodi"]);
                    cek_angkatan.append(data["angkatan"]);
                    form_nrp.prop('value',data["nrp"]);
                    div.show();
                    div.addClass('animated fadeInDown fast');
                    $("#cek").prop('disabled',false);
                },
                error: function ()
                {
                    nrp_salah.append(nrp);
                    form2_nrp.prop('value',nrp);
                    error.show();
                    error.addClass('animated fadeInDown fast');
                    $("#cek").prop('disabled',false);
                }
            });
    }
});
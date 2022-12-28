$('#tipe').select2();

let narahubung1 = $("#narahubung1");
narahubung1.select2({
    placeholder: "Masukkan nama narahubung",
    ajax: {
        type: "GET",
        url: "/ajax/cek_narahubung",
        dataType: "json",
        delay: 1000,
        minimumInputLength: 3,

        data: function (term) {
            return {
                key: term.term
            };
        },

        processResults: function (data) {
            console.log(data);
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item["nama"] + " | " + item["nrp"],
                        id: item["id_pengurus"],
                    }
                })
            };
        },
    }
});

narahubung1.on("change", function (){
    $.ajax({
        type: "GET",
        url: "/ajax/cek_kontak/" + narahubung1.val(),
        dataType: "json",

        success: function (data)
        {
            console.log(data);
            document.getElementById("no_wa1").value = data["no_wa"];
            document.getElementById("id_line1").value = data["id_line"];
        }
    });
});
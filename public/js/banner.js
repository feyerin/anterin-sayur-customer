function getAPIBanner() {
    url = "http://anterinsayur.id/api/banner";
    urlLocal = "http://localhost/anterin-sayur-customer/api/banner";

    $.ajax({
        type: 'GET',
        url: urlLocal,
        beforeSend: function () {},
        success: function (data) {
            displayBanner(data);
        },
        timeout: 300000,
        error: function (e) {
            console.log(e);
        }
    });
}

function displayBanner(data) {
    const banner = data.data;

    for(index=0; index<2; index++) {
        switch(index) {
            case(0):
                $('.banner-1').css('background-image','url("' + banner[index].imageurl + '")');
                break;
            case(1):
                $('.banner-2').css('background-image','url("' + banner[index].imageurl + '")');
                break;
        }
    }
}
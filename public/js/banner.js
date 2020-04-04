function getAPIBanner() {
    $.ajax({
        type: 'GET',
        url: "{{url('api/banner')}}",
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
    const url = 'url("http://anterinsayur.id/web';

    for(index=0; index<2; index++) {
        switch(index) {
            case(0):
                $('.banner-1').css('background-image',url+'public/'+banner[index].image);
                break;
            case(1):
                $('.banner-2').css('background-image',url+'public/'+banner[index].image);
                break;
        }
    }
}
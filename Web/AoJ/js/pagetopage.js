
let pagestatus = "court-list";

let widthsize = parseInt($('body').css('width').replace("px",""))

$(document).ready(function() {
    $('#court-detail').css('transform', 'translateX(' + widthsize + 'px)');
});

var toList = () => {
    anime({
        targets: '#'+pagestatus,
        translateX: widthsize,
        duration: 1500,
        easing: 'easeInOutCubic',
        autoplay: true,
        complete: function(anim) {
            $('#'+pagestatus).css('display', 'none');
            pagestatus = "court-list";
        }
    });
    
    anime({
        targets: '#court-list',
        translateX: 0,
        duration: 1500,
        easing: 'easeInOutCubic',
        autoplay: true,
        begin: function(anim) {
            $('#'+pagestatus).css('position', 'absolute');
            $('#court-list').css({'display': 'block', 'position': 'absolute'});
        },
    })

}

var toDetail = (idx, flag) => {

    let widthsize = parseInt($('body').css('width').replace("px",""))

    if(flag){
        let title = $('.idx-' + idx).find('.court-title').text()
        let content = $('.idx-' + idx).find('.court-content').text()
        let defendant = $('.idx-' + idx).find('.court-defendant').text()
        let delator = $('.idx-' + idx).find('.court-delator').text()
        let deadline = $('.idx-' + idx).find('.court-deadline').text()
        let defendant_point = parseInt($('.idx-' + idx).find('.court-defendant-point').text())
        let delator_point = parseInt($('.idx-' + idx).find('.court-delator-point').text())

        $('#court-detail').find('.court-detail-title').html(title)
        $('#court-detail').find('.court-detail-content').html(content)
        $('#court-detail').find('.court-detail-defendant-text').html(defendant)
        $('#court-detail').find('.court-detail-delator-text').html(delator)
        $('#court-detail').find('.court-detail-deadline-text').html(deadline)
        $('#court-detail').find('.court-detail-count-text').html(defendant_point + delator_point + "명")
        $('#court-detail').attr('idx', idx)
    }else{
        let title = $('.idx-' + idx).find('.court-title').text()
        let content = $('.idx-' + idx).find('.court-content-text').text()
        let defendant = $('.idx-' + idx).find('.court-defendant').text()
        let delator = $('.idx-' + idx).find('.court-delator').text()
        let deadline = $('.idx-' + idx).find('.court-deadline').text()
        let defendant_point = parseInt($('.idx-' + idx).find('.court-defendant-point').text())
        let delator_point = parseInt($('.idx-' + idx).find('.court-delator-point').text())

        $('#court-detail').find('.court-detail-title').html(title)
        $('#court-detail').find('.court-detail-content').html(content)
        $('#court-detail').find('.court-detail-defendant-text').html(defendant)
        $('#court-detail').find('.court-detail-delator-text').html(delator)
        $('#court-detail').find('.court-detail-deadline-text').html(deadline)
        $('#court-detail').find('.court-detail-count-text').html(defendant_point + delator_point + "명")    
        $('#court-detail').attr('idx', idx)
    }

    $('.court-defendant-content').html("")
    $('.court-delator-content').html("")
    $('.court-community-chat').html("")

    pusher.subscribe('defendant-'+idx).bind('add', function(data) {
        $('.court-defendant-content').append('<div class="court-comment court-defendant-1">'+ data.message +'</div>')
        $(".court-defendant-content").scrollTop($(".court-defendant-content")[0].scrollHeight)
    })

    pusher.subscribe('delator-'+idx).bind('add', function(data) {
        $('.court-delator-content').append('<div class="court-comment court-delator-1">'+ data.message +'</div>')
        $(".court-delator-content").scrollTop($(".court-delator-content")[0].scrollHeight)
    })

    pusher.subscribe('allchat-'+idx).bind('add', function(data) {
        $('.court-community-chat').append('<div class="court-chat court-chat-1">'+ data.message +'</div>')
        $(".court-community-chat").scrollTop($(".court-community-chat")[0].scrollHeight)
    })

    $.ajax({
        url: '/init.php',
        async: true,
        type: 'POST',
        data: {
            idx: idx
        },
        dataType: 'text'
    })

    anime({
        targets: '#'+pagestatus,
        translateX: -widthsize,
        duration: 1500,
        easing: 'easeInOutCubic',
        autoplay: true,
        complete: function(anim) {
            $('#'+pagestatus).css('display', 'none');
            $('#court-detail').css('position', 'block');
            pagestatus = "court-detail";
        }
    });

    anime({
        targets: '#court-detail',
        translateX: 0,
        duration: 1500,
        easing: 'easeInOutCubic',
        autoplay: true,
        begin: function(anim) {
            $('#'+pagestatus).css('position', 'absolute');
            $('#court-detail').css({'display': 'block', 'position': 'absolute'});
          },
    });

}


var openCommunity = () => {

    anime({
        targets: '#court-community',
        opacity: 1,
        duration: 1000,
        easing: 'easeInOutCubic',
        autoplay: true,
        complete: function(anim) {
            pagestatus = "court-community";
        },
        begin: function(anim) {
            $('#court-community').css({'display': 'block'});
        },
    });


}


var closeCommunity = () => {
    anime({
        targets: '#court-community',
        opacity: 0,
        duration: 1000,
        easing: 'easeInOutCubic',
        autoplay: true,
        complete: function(anim) {
            $('#court-community').css({'display': 'none'});
            pagestatus = "court-detail";
        }
    });
}


var vote = poue => {
    let idx = parseInt($('#court-detail').attr('idx'))
    $.ajax({
        url: '/vote.php',
        async: false,
        type: 'POST',
        data: {
            type: poue,
            idx: idx
        },
        dataType: 'text',
        success: function(jqXHR) {
            alert('Sucess!');
            
        }
    })
}
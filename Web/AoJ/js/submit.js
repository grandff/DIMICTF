function defendant(t){
    if(window.event.keyCode == 13){
        let idx = parseInt($('#court-detail').attr('idx'))
        let comment = t.value
        $.ajax({
            url: '/community.php',
            async: false,
            type: 'POST',
            data: {
                type: 1,
                idx: idx,
                comment: comment
            },
            success: () => {
                t.value=""
            },
            dataType: 'text'
        })
    }
}

function delator(t){
    if(window.event.keyCode == 13){
        let idx = parseInt($('#court-detail').attr('idx'))
        let comment = t.value
        $.ajax({
            url: '/community.php',
            async: false,
            type: 'POST',
            data: {
                type: 2,
                idx: idx,
                comment: comment
            },
            success: () => {
                t.value=""
            },
            dataType: 'text'
        })
    }
}

function allchat(t){
    if(window.event.keyCode == 13){
        let idx = parseInt($('#court-detail').attr('idx'))
        let comment = t.value
        $.ajax({
            url: '/community.php',
            async: false,
            type: 'POST',
            data: {
                type: 3,
                idx: idx,
                comment: comment
            },
            success: () => {
                t.value=""
            },
            dataType: 'text'
        })
    }
}






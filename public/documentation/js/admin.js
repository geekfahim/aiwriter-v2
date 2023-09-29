$('.dropdown-menu-link').on('click', function(e){
    $(this).toggleClass('dropdown-active');
})

$('.js-logo-upload').change(function(e) {
    e.preventDefault();
    var el = $(this);
    //readURL(el);
    changeLogo($('.js-upload-logo-form'));
});

$('.js-favicon-upload').change(function(e) {
    e.preventDefault();
    var el = $(this);
    //readURL(el);
    changeLogo($('.js-upload-favicon-form'));
});

function changeLogo(el){
    var el = el;

    $.ajax({
        url           : el.attr('action'),
        method        : "POST",
        headers       : {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
        data          : new FormData(el[0]),
        contentType   : false,
        cache         : false,
        processData   : false,
        error         : function(data) {},
        success       : function(data){
            var content = JSON.parse(data);
        }
    })
}

$(document).on('click', '.js-add, .js-edit', function(e){
    e.preventDefault();
    var el = $(this);

    $.ajax({
        url: el.data('url'),
        method: 'GET',
        dataType: 'html',
        error: function(res){},
        success: function(res){
            $('.js-modal-view').html(res);
            $('.js-modal').modal('show');
        }
    })
})

$(document).on('submit', '.js-add-form', function(e){
    e.preventDefault();
    var el = $(this);
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').remove();
  
    $.ajax({
        url       : el.attr('action'),
        method    : 'POST',
        data      : el.serialize(),
        dataType  : 'json',
        error     : function(res){},
        success   : function(res){
            if(res.success == true){
              $('.js-add-modal').modal('hide');
              showNotification(res.message)
            } else {
              $.each(res.errors, function(k, v){
                  var msg = '<div class="invalid-feedback" for="'+ k +'">'+ v +'</div>';
                  $('input[name='+k+'],textarea[name='+k+']').addClass('is-invalid').after(msg);
              });
            }
        }
    })
})

$(document).on('submit', '.js-edit-payment', function(e){
    e.preventDefault();
    var el = $(this);
    $('.is-invalid').removeClass('is-invalid');

    $.ajax({
        url: el.attr('action'),
        method : 'POST',
        data : el.serialize(),
        dataType : 'json',
        success : function(res){
            if(res.success){
                window.location.reload();
            } else {
                $.each(res.errors, function(k,v){
                    $('input[name="'+k+'"]').addClass('is-invalid');
                })
            }
        }
    })
})

$(document).on('click', '.viewModal', function(e){
    var el = $(this);

    $.ajax({
        url : el.data('url'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method : 'GET',
        dataType : 'HTML',
        success : function(res){
            $('.js-add-view').html(res);
            $('#editModal').modal('show');
        }
    })
})

$(document).on('change', '.js-status-change', function(e){
    e.preventDefault();
    var el = $(this)

    console.log(el.closest('form').attr('action'));

    $.ajax({
        url : el.closest('form').attr('action'),
        method : 'POST',
        data : el.closest('form').serialize(),
        dataType : 'json',
        success : function(res){
            window.location.reload();
        }
    })
})

$(document).on('submit','.js-create', function(e){
    e.preventDefault();
    var el = $(this);
    $('.invalid-feedback').remove();
    $('.is-invalid').removeClass('is-invalid');
    $.ajax({
        url      : el.attr('action'),
        method   : 'POST',
        data     : el.serialize(),
        dataType : 'json',
        success  : function(res){
            if(res.success){
                window.location.reload();
            } else {
                $.each(res.errors, function(k, v){
                    var error = '<div class="invalid-feedback">'+v+'<div>'
                    $('input[name='+k+'],textarea[name='+k+']').addClass('is-invalid').after(error);
                })
            }
        }
    })
})

$('.js-change-status').on('click', function(e){
    var el = $(this);
    bootbox.confirm({
        title: "Confirm action", 
        message: el.data('message'), 
        callback: function(result){
            if (result == true){
                $.ajax({
                    url      : el.data('url'),
                    method   : 'GET',
                    data     : el.serialize(),
                    dataType : 'json',
                    success  : function(res){
                        if(res.success){
                            window.location.reload();
                        } else {
                            $.each(res.errors, function(k, v){
                                var error = '<div class="invalid-feedback">'+v+'<div>'
                                $('input[name='+k+']').addClass('is-invalid').after(error);
                            })
                        }
                    }
                })
            }
        }
    });
})

$('.js-edit-template').on('submit', function(e){
    e.preventDefault();
    var el = $(this);

    $.ajax({
        url      : el.attr('action'),
        method   : 'POST',
        data     : el.serialize(),
        dataType : 'json',
        success  : function(res){
            if(res.success){
                window.location.reload();
            }
        }
    })
})

$(document).on('change', 'select[name="subscription_plan_id"], select[name="subscription_type"]', function(e){
    var pl = $('select[name="subscription_plan_id"]').val();
    var pr = $('select[name="subscription_type"]').val();

    $.ajax({
        url : './settings/plans/price/'+pl,
        method : 'GET',
        data : {period : pr},
        dataType : 'json',
        success: function(res){
            $('.subscription-plan-settings').removeClass('d-none');
            $('input[name="amount"]').val(res.amount);
        }
    })
})

$(document).on('keyup', '.search-box', function() {
    var el = $(this);
    var query = el.val();
    var url = el.data('url');

    $.ajax({
        url: url,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {query : query},
        dataType : 'HTML',
        success: function(data) {
            $('#table-render').html(data);
        }
    });
});

function showNotification(message) {
    const notification = $('<div>').addClass('notification').text(message);
    const progress = $('<div>').addClass('progress');
    notification.append(progress);
    $('body').append(notification);

    let startTime = new Date();
    let interval = setInterval(() => {
        let currentTime = new Date();
        let elapsedTime = (currentTime - startTime) / 1000;
        let width = (elapsedTime / 5) * notification.width();
        progress.css('width', width + 'px');
        if (width >= notification.width() - 2) {
            clearInterval(interval);
            notification.hide();
        }
    }, 40);

    notification.on('click', () => {
        clearInterval(interval);
        notification.hide();
    });
}

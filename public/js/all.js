
//Input vacacy atendimento
$('[name=monthly]').on("click",function(event) {
    valor = $(this).val()
    if(valor==="yes")
    {
        $('#cpf').attr('disabled',false)
        $('#cpf').attr('required',true)
        $('#cpf').focus()
    }
    else{
        $('#cpf').attr('disabled',true)
        $('#cpf').attr('required',false)

    }
});
  //validation order
  $(document).on("change","#vacancy_id",function(event) {
    value = $(this).val()
    ocup = $('#vacancy'+value).attr('data-vFree')
    if(ocup!=="true")
    {
        $('#error').removeClass('fade')
        $(this).addClass('border border-danger')
        $('#save').attr('disabled','disabled')
        $('#print').attr('disabled','disabled')
    }
    else
    {
        $('#error').addClass('fade')
        $(this).removeClass('border border-danger')
        $('#save').attr('disabled',false)
        $('#print').attr('disabled',false)
    }

});

    // add Vacancies
    $('[data-url]').click(function(e){
    	urlRed = $(this).data('url')
    	urlHome = $('#formVacancy').attr('data-home')
    	token = $('[name=_token]').val()
    	order = $('#order').val();
    	e.preventDefault()
    	$.ajax({
    		url: urlRed,
    		type: 'post',
    		data: {
    			'_token':token,
    			'order' :order
    		},
    		dataType: 'json',
    		success:function(result)
    		{
    		},
    	}) 
    	$('body').load(urlHome)
    })

    // Update price

    $('[data-url-price]').click(function(e){
        price = $('#price').val();
        urlRed = $(this).attr('data-url-price')
        urlHome = $('#formVacancy').attr('data-home')
        token = $('[name=_token]').val()
        

        e.preventDefault()
        $.ajax({
            url: urlRed,
            type: 'get',
            dataType: 'json',
            data: {
                'token':token,
                'price':price

            },
            success: function(success){
                console.log(success)
            }  , 
            error: function(result) {
                console.log(result)
            }
        })
        
        
    })

    // AddPArk
    $('#save').click(function(event) {
        url = $(this).attr('data-addPark')

        vacancy_id = $('#vacancy_id').val()
        cpf = $('#cpf').val()
        if(cpf=="")cpf="0"
            model = $('#model').val()
        board = $('#board').val()
        home = $('#home').data('home')
        token = $('[name=_token]').val()

        event.preventDefault()
        $.ajax({

            url: url,
            data: {
                "_token":token,
                "vacancy_id": vacancy_id,
                "cpf": cpf,
                "model": model,
                "board": board
            },
            type:'post',
            dataType:'json',
            success: function(result)
            {
                console.log("success")
            }
        })
        $('body').load(home)
        $('#addModal').hide('slow');
    })

    $('#btn-output').on("click",function(){
        $('#inputPark').hide('slow')
        $('#outputPark').show('slow')
        $('#title').text("Saída")
        $('#btn-input').show()
        $('#btn-output').hide('slow')
    })
    $('#btn-input').on("click",function(){
        $('#inputPark').show('slow')
        $('#title').text("Entrada")
        $('#outputPark').hide('slow')
        $('#btn-input').hide('slow')
        $('#btn-output').show('slow')
    })

    // LoadOutput 
    $(function(){
        board = $('#out-board').val()
        $('#search').click(function(){
            var url = $('#out-board').attr('data-loadInput')+"/"+$('#out-board').val()
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                data: {

                },
            })
            .done(function(result) {
                console.log(result)

                if(result!==1)
                {
                    $('#out-vacancy_id').val(result['0'])
                    $('#out-model').val(result['3'])
                    $('#inputTime').val(result['4'])
                    $('#totalPay').val("R$ "+result['5'])
                    $('#outputTime').val(result['6'])
                    $('#id').val(result['9'])
                    if(result['8']>0){
                        $('#permanency').val(result['8']+"Dia(s) + "+ result['7'])   
                    }
                    else
                    {
                        $('#permanency').val(result['7'])
                    }
                    $('#vacancy'+result['0']).addClass('animate')
                    $('#vacancy'+result['0']).parent().addClass('bg-black')
                    setTimeout(function(){
                        $('#vacancy'+result['0']).removeClass('animate')
                        $('#vacancy'+result['0']).parent().removeClass('bg-black')
                    },10000)
                    $('#closeStay').attr("disabled",false);
                }else
                {
                    $('#out-board').addClass('border border-danger')
                    $('#info').show()
                    setTimeout(function(){
                        $('#out-board').removeClass('border border-danger')
                        $('#info').hide()
                        $('#out-board').focus()
                    },10000)
                }

            })

        })
    })
// Modal Confirm
$("#closeStay").click(function() {
    $('#confirm').modal()
    $('#info-vacancy').text($('#out-vacancy_id').val())
    $('#info-model').text($('#out-model').val())
    $('#info-permanence').text($('#permanency').val())
    $('#info-pay').text($('#totalPay').val())
    board = $('#out-board').val()
    $('#printBoard').val(board)
});
// Open Modal AddVacancy
$('#btn-addVacancy').click(function(){
    $('#addModal').modal()
})


//Acoes imprimir os
$('#print').click(function(){
    $(this).removeClass('bg-black').addClass('btn-primary')
    $('#confirm').modal('hide')    
        $('#formPrint').submit()
    
})


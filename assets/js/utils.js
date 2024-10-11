function showBlock(selector) {
    if($(selector).hasClass('hidden'))
    $(selector).removeClass('hidden')
}

function hiddenBlock(selector) {
    if(!$(selector).hasClass('hidden')) {
    $(selector).addClass('hidden')
    }
}


function showResult(result, selector) {
    const nameClassSuccess = 'success-field'
    if(!$(selector).hasClass(nameClassSuccess)) {
        $(selector).addClass(nameClassSuccess)
    }
    $(selector).text(result)
    setTimeout(() => {
        $(selector).text('')
        $(selector).removeClass(nameClassSuccess)
    }, 3000)
}

function showError(error, selector) {
    const nameClassError = 'error-field'
    if(!$(selector).hasClass(nameClassError)) {
        $(selector).addClass(nameClassError)
    }
    $(selector).text(error)
    setTimeout(() => {
        $(selector).text('')
        $(selector).removeClass(nameClassError)
    }, 3000)
}


// TODO BETTER
function validationForm(selectors = []) {
    let valid = true
    for(let i = 0; i < selectors.length; i++) {
        if(selectors[i].val().length <= 0) {
            console.log(i)
            valid = false
            console.log(selectors[i].next().attr('id'))
            showError('Поле не должно быть пустым!', '#' + selectors[i].next().attr('id'))
        }
    }
    return valid
}
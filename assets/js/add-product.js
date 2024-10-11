const nameProduct = $('#name-form-input')
const price = $('#price-form-input')
const tariff = $('#tariff-form-input')
const addBtn = $('.btn-success')
function addProduct() {
  if(validationForm([nameProduct, price])) {
    showBlock('.lds-ring')
    $.ajax({
        url: '/a25/App/Api/AddProduct.php',
        method: 'POST',
        data: {
          name: nameProduct.val(),
          price: price.val(),
          tariff: tariff.val()
        },
        success: (data, textStatus, jqXHR) => {
          if(textStatus === 'success') {
            showResult("Продукт успешно добавлен", '.result')
            setTimeout(() => {
              window.location = 'index.php'
            }, 3000)
          }
          else {
            showError(JSON.parse(data['message']), '.result')
          }
          hiddenBlock('.lds-ring')
        },
        error: error => {
          hiddenBlock('.lds-ring')
          showError(JSON.parse(error.responseText)['message'], '.result')
        }
      })
       
  }
}

addBtn.click(e => {
    addProduct()
})
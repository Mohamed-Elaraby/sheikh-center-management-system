$(document).ready(function () {

    let count = 1,
        price,
        quantity,
        calc_amount_taxable,
        discount_per_item,
        calc_tax_amount,
        calc_subTotal,
        discount_row_removed,
        sub_total_row_removed,
        amount_taxable_row_removed,
        amount_paid,
        amount_paid_bank,
        tax_row_removed,
        calcTotal,
        calcSubTotal,
        discount_amount_or_percentage,
        calc_tax,
        calc_taxable_amount,
        calc_discount,
        discount_type,
        _total_element = $('#total'),
        _discount_element = $('#discount'),
        _discount_type_element = $('.discount_type'),
        _taxable_amount_element = $('#taxable_amount'),
        _total_amount_due_element = $('#total_amount_due'),
        // _amount_paid_element = $('#amount_paid'),
        _amount_due_element = $('#amount_due'),
        _total_vat_element = $('#total_vat');
        _card_details_tax_element = $('#card_details_tax');
    let total_amount_due_with_round ;
    let amount_due_with_round ;
    let total_amount_due_without_round ;
    let amount_due_without_round ;

    // make button to remove select elements
    $(document).on('click', '.removeField', function () {
        let selectedRow = $(this).closest('tr');
        let productCode = selectedRow.find('.item_code').val();

        $('#product_code_'+ productCode).addClass('btn-success').removeClass('btn-default disabled');
        amount_taxable_row_removed = $(this).closest('tr').find('.item_amount_taxable').val();
        discount_row_removed = $(this).closest('tr').find('.item_discount_amount').val();
        tax_row_removed = $(this).closest('tr').find('.item_tax_amount').val();
        sub_total_row_removed = $(this).closest('tr').find('.item_sub_total').val();
        calc_items_total_amounts(amount_taxable_row_removed, discount_row_removed, tax_row_removed, sub_total_row_removed);
        putHandLabourAndPartsAmount();
        $(this).closest('tr').remove();
    });

    // calculating invoice data
    function calc_items_total_amounts(taxable_amount_removed = 0, discount_removed = 0, tax_removed = 0, subtotal_removed = 0) {
        amount_paid_bank = parseFloat($('#amount_paid_bank').val()) || 0 ; // init amount paid
        amount_paid = parseFloat($('#amount_paid').val()) || 0 ; // init amount paid

        // console.log(amount_paid_bank);
        // console.log(amount_paid);
        // calc amount_taxable value and insert value into total element
        let amount_taxable_value = 0;
        $('input.item_amount_taxable').each(function () {
            amount_taxable_value += +$(this).val() ;
            calcTotal = (amount_taxable_value);
            _total_element.val((calcTotal - taxable_amount_removed).toFixed(2)); // insert total amount inside total input
        });

        // calc discount value and insert value into discount element
        let discount_value = 0;
        $('input.item_discount_amount').each(function () {
            discount_value += +$(this).val() || 0;
            calc_discount = (discount_value);
            _discount_element.val((calc_discount - discount_removed).toFixed(2)); // insert discount amount inside discount input
        });

        // calc item tax amount value and insert value into total vat element
        let tax_value = 0;
        $('input.item_tax_amount').each(function () {
            tax_value += +$(this).val() || 0;
            calc_tax = (tax_value);
            _total_vat_element.val((calc_tax - tax_removed).toFixed(2)); // insert tax_amount amount inside tax_amount input
            _card_details_tax_element.val((calc_tax - tax_removed).toFixed(2)); // insert total amount inside total input
        });

            // calc item sub total value and insert value into total amount due element and amount due element
        let subtotal_value = 0;
        $('input.item_sub_total').each(function () {
            subtotal_value += +$(this).val() || 0;
            calcSubTotal = (subtotal_value);
            total_amount_due_with_round = Math.round((calcSubTotal - subtotal_removed)).toFixed(2);
            amount_due_with_round = Math.round(((calcSubTotal - subtotal_removed) - (amount_paid + amount_paid_bank))).toFixed(2);
            total_amount_due_without_round = (calcSubTotal - subtotal_removed).toFixed(2);
            amount_due_without_round = ((calcSubTotal - subtotal_removed) - (amount_paid + amount_paid_bank)).toFixed(2);
            if ($('#rounding_amount').hasClass('btn-danger'))
            {
                // Rounding [ total_amount_due ] and [ amount_due ]
                _total_amount_due_element.val(Math.round((calcSubTotal - subtotal_removed)).toFixed(2)); // insert total amount inside total input
                _amount_due_element.val(Math.round(((calcSubTotal - subtotal_removed) - (amount_paid + amount_paid_bank))).toFixed(2)); // insert total amount inside total input
            }else
            {
                _total_amount_due_element.val((calcSubTotal - subtotal_removed).toFixed(2)); // insert total amount inside total input
                _amount_due_element.val(((calcSubTotal - subtotal_removed) - (amount_paid + amount_paid_bank)).toFixed(2)); // insert total amount inside total input
            }

        });

        // calc item taxable amount value and insert value into taxable amount element
        calc_taxable_amount = _total_element.val() && _discount_element.val()? parseFloat(_total_element.val() - _discount_element.val() || 0).toFixed(2) : '';
        _taxable_amount_element.val(calc_taxable_amount);

    }

    // Rounding [ total_amount_due ] and [ amount_due ]
    $('#rounding_amount').on('click', function () {
        if ($(this).hasClass('btn-danger'))
        {
            $(this).addClass('btn-success').removeClass('btn-danger').text('تقريب المبلغ');

            _total_amount_due_element.val(total_amount_due_without_round); // insert total amount inside total input
            _amount_due_element.val(amount_due_without_round); // insert total amount inside total input


        }else
        {
            $(this).removeClass('btn-success').addClass('btn-danger').text('الغاء التقريب');
            _total_amount_due_element.val(total_amount_due_with_round); // insert total amount inside total input
            _amount_due_element.val(amount_due_with_round); // insert total amount inside total input
        }
    });

    // calculating sub total amount per item
    $(document).on('keyup change', ':input', function () {

        let row = $(this).closest('tr');

        quantity = row.find('.item_quantity').val() || 0; // get quantity
        price = row.find('.item_price').val() || 0; // get price

        calc_amount_taxable = parseFloat(((price * quantity).toFixed(2))); // calculation amount taxable for item
        row.find('.item_amount_taxable').val(calc_amount_taxable); // insert amount taxable items into amount taxable field

        discount_type = row.find('.discount_type').val();

        discount_per_item = parseFloat( row.find('.item_discount').val() || 0); // if discount value not empty get value else get zero

        discount_amount_or_percentage = discount_type == 1 ? ( calc_amount_taxable * discount_per_item /100):discount_per_item;

        row.find('.item_discount_amount').val(discount_amount_or_percentage);
        row.find('.item_sub_total_after_discount').val(calc_amount_taxable - discount_amount_or_percentage);

        // console.log(discount_amount_or_percentage);

        calc_tax_amount = parseFloat(((calc_amount_taxable - discount_amount_or_percentage) * (15/100)).toFixed(2));
        row.find('.item_tax_amount').val(calc_tax_amount);
        calc_subTotal = (calc_amount_taxable - discount_amount_or_percentage + calc_tax_amount).toFixed(2); // calculation sub total for item
        row.find('.item_sub_total').val(calc_subTotal); // insert sub total items into sub total field
        calc_items_total_amounts();
        putHandLabourAndPartsAmount();
    });
    putHandLabourAndPartsAmount();
    function makeToFixedNumber(num) {
        // return Math.trunc(num*100)/100;
        return Math.round(num * 100) / 100;
    }

    function putHandLabourAndPartsAmount() {

        let amount_paid = parseFloat($('#amount_paid').val())|| 0;
        let amount_paid_bank = parseFloat($('#amount_paid_bank').val())|| 0;

        let total_amounts_paid  = parseFloat(amount_paid + amount_paid_bank);
        console.log('total_amounts_paid = ' + total_amounts_paid, typeof total_amounts_paid);

        let hand_labour = parseFloat($('#hand_labour').val())|| 0;
        let new_parts = parseFloat($('#new_parts').val())|| 0;
        let used_parts = parseFloat($('#used_parts').val())|| 0;


        let calculate_tax_amount = makeToFixedNumber(total_amounts_paid - ( total_amounts_paid / 1.15)); /* 15% */
        let card_details_tax = $('#card_details_tax');
        let total_card_details_amount = hand_labour + new_parts + used_parts + calculate_tax_amount;

        card_details_tax.val(calculate_tax_amount);
        console.log('total_card_details_amount = ' + total_card_details_amount, typeof total_card_details_amount);
        console.log('calculate_tax_amount = ' + calculate_tax_amount, typeof calculate_tax_amount);




        // let total_vat = parseFloat(_total_vat_element.val())|| 0;
        // let total_amount_due = parseFloat($('#total_amount_due').val());
        // let total_card_details_amount = hand_labour + new_parts + used_parts + total_vat;

        if (total_amounts_paid > 0)
        {
            if (total_card_details_amount < 1 || total_card_details_amount > total_amounts_paid)
            {
                $('#card_details_error').addClass('hasError').css({'display': 'inline', 'font-size': 'small', 'font-style': 'italic', 'margin-bottom': '5px', 'font-weight': '700'}).text('برجاء ادخال اجمالى مبالغ تفاصيل الكارت بشكل صحيح بحيث يكون الاجمالى = ' + total_amounts_paid);
            }
            else if (total_card_details_amount !== total_amounts_paid)
            {
                let calc = parseFloat(total_amounts_paid - total_card_details_amount).toFixed(2);
                $('#card_details_error').addClass('hasError').css({'display': 'inline', 'font-size': 'small', 'font-style': 'italic', 'margin-bottom': '5px', 'font-weight': '700'}).text('اجمالى المبلغ الذى ادخلته ' + total_card_details_amount + ' مع الضريبة لا يساوى اجمالى مبلغ الفاتورة المقدر ب ' + total_amounts_paid + ' متبقى ' + calc);
            }
            else
            {
                $('#card_details_error').removeClass('hasError').css('display','none').text();
            }
        }else
        {
            $('#hand_labour, #new_parts, #used_parts').val('');
            $('#card_details_error').removeClass('hasError').css('display','none').text();
        }
    }
});

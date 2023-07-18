$(document).ready(function () {



    let quantity,
        price,
        calc_amount_taxable,
        discount_type,
        discount_per_item,
        discount_amount_or_percentage,
        calc_tax_amount,
        calc_subTotal,
        _total_element = $('#total'),
        _discount_element = $('#discount'),
        _taxable_amount_element = $('#taxable_amount'),
        _total_vat_element = $('#total_vat');
        _total_return_items_element = $('#total_return_items');
    var total_return_items_with_round ;
    var total_return_items_without_round ;

    function calcTotalAmounts() {
        let total = 0;
        let discount = 0;
        let taxable_amount = 0;
        let total_vat = 0;
        total_return_items_with_round = 0;
        total_return_items_without_round = 0;
        // let total_return_items = 0;
        $('input[type="checkbox"]:checked').each(function () {
            let that = $(this);
            let rowSelected = that.closest('tr');
            total += parseFloat(rowSelected.find('.item_amount_taxable').val());
            discount += parseFloat(rowSelected.find('.item_discount_amount').val());
            taxable_amount += parseFloat(rowSelected.find('.item_sub_total_after_discount').val());
            total_vat += parseFloat(rowSelected.find('.item_tax_amount').val());
            total_return_items_with_round += Math.round(parseFloat(rowSelected.find('.item_sub_total ').val()));
            total_return_items_without_round += parseFloat(rowSelected.find('.item_sub_total ').val());
            // total_return_items += parseFloat(rowSelected.find('.item_sub_total ').val());
        });
        _total_element.val((total).toFixed(2)); // insert total amount inside total input
        _discount_element.val((discount).toFixed(2)); // insert total amount inside total input
        _taxable_amount_element.val((taxable_amount).toFixed(2)); // insert total amount inside total input
        _total_vat_element.val((total_vat).toFixed(2)); // insert total amount inside total input

        _total_return_items_element.val((total_return_items_without_round).toFixed(2)); // insert total amount inside total input

    }

    // Rounding [ total_amount_due ] and [ amount_due ]
    $('#rounding_amount').on('click', function () {
        if ($(this).hasClass('btn-danger'))
        {
            console.log('with_out')
            $(this).addClass('btn-success').removeClass('btn-danger').text('تقريب المبلغ');

            _total_return_items_element.val((total_return_items_without_round).toFixed(2)); // insert total amount inside total input


        }else
        {
            console.log('with')
            $(this).removeClass('btn-success').addClass('btn-danger').text('الغاء التقريب');

            _total_return_items_element.val((total_return_items_with_round).toFixed(2)); // insert total amount inside total input

            // _total_amount_due_element.val(total_amount_due_with_round); // insert total amount inside total input
            // _amount_due_element.val(amount_due_with_round); // insert total amount inside total input
        }
    });


    // calculating sub total amount per item
    $(document).on('keyup change', '.item_quantity, input[type="checkbox"]', function () {

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
        calcTotalAmounts();
    });

});

<script>
    $(document).ready(function() {

        $('#customers').select2({
            theme: 'bootstrap4'
        });

        function rupiahToInt(num) {
            if (typeof(num) !== 'string') return false;
            for (let i = 0; i < num.length; i++) {
                num = num.replace('.', '');
            }
            return parseInt(num);
        }

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }

        function toRupiah(num) {
            return 'Rp. ' + formatNumber(num);
        }

        function CreateRow(id, product_name, price, cost, cost_type, qty) {
            const rowIndex = $('#sales-table tbody tr').length + 1;
            let row = "<tr>";
            row += "<td>";
            row += "<span>" + rowIndex + "</span>";
            row += "</td>";
            row += "<td>";
            row += "<input type='hidden' id='product_id' name='product_id[]' value='" + id + "'>";
            row += "<input type='hidden' id='product_name' name='product[]' value='" + product_name + "'>";
            row += "<span>" + product_name + "</span>";
            row += "</td>";
            row += "<td>";
            row += "<input type='hidden' id='price' name='price[]' value='" + price + "'>";
            row += "<input type='hidden' id='cost' name='cost[]' value='" + cost + "'>";
            row += "<input type='hidden' id='cost-type' name='cost_type' value='" + cost_type + "'>";
            row += "<span>" + toRupiah(price + cost) + "</span>";
            row += "</td>";
            row += "<td><input type='number' min='0' class='form-control' id='extra_price' name='extra_price[]' value='0'></td>";
            row += "<td><input type='number' min='1' class='form-control' id='qty' name='qty[]' value='1'></td>";
            row += "<td>";
            row += "<input type='hidden' id='sub-total' name='sub_total[]' value='" + (price + cost) * qty + "'>";
            row += "<span>" + toRupiah((price + cost) * qty) + "</span>";
            row += "</td>";
            row += "<td><button class='btn btn-danger' id='delete-row'><i class='fa fa-times'></i></button></td>";
            row += "</tr>";

            $('#sales-table tbody').append(row);

            $('#sales-table tbody tr').each(function() {
                $(this).find('td:nth-child(2) input').focus();
            });
        }

        function CountTotalPayment() {
            let total = 0;
            $('#sales-table tbody tr').each(function() {
                let subTotal = $(this).find('td:nth-child(6) input').val();
                total += parseInt(subTotal);
            });
            $('#total-payment h2').html('Total: ' + toRupiah(total));
            $('#total-payment input').val(total);
        }

        function CountAmountedPayment() {
            const payment = ($('#amounted-payment').val() === '') ? 0 : rupiahToInt($('#amounted-payment').val());
            const totalPayment = $('#total-payment input').val();
            const change = parseInt(payment) - parseInt(totalPayment);
            $('#change').val(formatNumber(change));
            CheckStatus();
        }

        function CheckStatus() {
            const change = rupiahToInt($('#change').val());
            if (change >= 0) {
                $('span#status').removeClass('text-danger');
                $('span#status').text('Lunas').addClass('text-success');
            } else {
                $('span#status').text('Hutang');
                $('span#status').addClass('text-danger');
            }
        }

        $('#amounted-payment').on('input', function() {
            CountAmountedPayment();
        })

        $(document).on('click', '#delete-row', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();

            let no = 1;
            $('#sales-table tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no);
                no++;
            });

            CountTotalPayment();
            CountAmountedPayment();

        });

        $(document).on('keyup input', '#extra_price', function(e) {
            const charCode = e.which || e.keyCode;
            if (charCode != 8 && charCode <= 48 && charCode >= 57) return false;

            const extraPrice = parseInt($(this).val());
            const qty = $(this).parent().parent().find('td:nth-child(5) input').val();
            const subTotalInput = $(this).parent().parent().find('td:nth-child(6) input');
            const subTotalSpan = $(this).parent().parent().find('td:nth-child(6) span');
            const priceInput = $(this).parent().parent().find('td:nth-child(3) input');
            const priceSpan = $(this).parent().parent().find('td:nth-child(3) span');
            const price = parseInt($(priceInput).val());

            const customer = GetCustomer();
            const costType = $(this).parent().parent().find('td:nth-child(3) input#cost-type').val()
            const cost = CalculateCost(costType, customer.category_id);
            let subTotal = 0;

            if (!isNaN(extraPrice)) {
                subTotal = (price + cost + extraPrice) * qty;
                subTotalInput.val(subTotal);
                subTotalSpan.html(toRupiah(subTotal));
            } else {
                subTotal = (price + cost + 0) * qty;
                subTotalInput.val(subTotal);
                subTotalSpan.html(toRupiah(subTotal));
            }

            CountTotalPayment();
            CountAmountedPayment();

        });

        $(document).on('keyup input', '#qty', function(e) {
            const charCode = e.which || e.keyCode;
            if (charCode != 8 && charCode <= 48 && charCode >= 57) return false;

            const qtyInput = $(this);
            let qty = parseInt($(this).val());
            const id = $(this).parent().parent().find('td:nth-child(2) input').val();
            const extraPrice = parseInt($(this).parent().parent().find('td:nth-child(4) input').val());
            const subTotalInput = $(this).parent().parent().find('td:nth-child(6) input');
            const subTotalSpan = $(this).parent().parent().find('td:nth-child(6) span');
            const priceInput = $(this).parent().parent().find('td:nth-child(3) input');
            const priceSpan = $(this).parent().parent().find('td:nth-child(3) span');
            const price = parseInt($(priceInput).val());

            console.log(id);
            if ($(this).val() != '') {
                const reg = new RegExp('^[0-9]+$');

                $.ajax({
                    url: "<?= site_url('Sales/getInventory'); ?>",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    async: false,
                    success: function(data) {
                        if (data.stock < qty) {
                            qtyInput.val(data.stock);
                            qty = data.stock;
                            alert('STOK TIDAK MENCUKUPI !! \nStok tersisa : ' + data.stock);
                        }
                        // e.preventDefault();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })

                if (reg.test(qty)) {
                    const customer = GetCustomer();
                    const costType = $(this).parent().parent().find('td:nth-child(3) input#cost-type').val()
                    const cost = CalculateCost(costType, customer.category_id);
                    let subTotal = 0;
                    subTotal = (price + cost + extraPrice) * qty;
                    subTotalInput.val(subTotal);
                    subTotalSpan.html(toRupiah(subTotal));
                }

            } else {
                subTotalInput.val(0);
                subTotalSpan.html(toRupiah(0));
            }

            CountTotalPayment();
            CountAmountedPayment();
        })

        $('#inputProduct').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= site_url('Sales/getInventories'); ?>",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        keyword: request.term
                    },
                    success: function(data) {
                        let product = [];
                        $.each(data, function(i, val) {
                            const object = {
                                id: val.id,
                                value: val.product_name
                            }
                            product.push(object);
                        })
                        response(product);
                    }
                })
            },
            select: function(event, ui) {
                $.ajax({
                    url: "<?= site_url('Sales/getInventory'); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        id: ui.item.id
                    },
                    success: function(data) {
                        const price = parseInt(data.sale_price);
                        const cost_type = data.delivery_cost_type;
                        const qty = 1;
                        const customer = GetCustomer();
                        const cost = CalculateCost(cost_type, customer.category_id);
                        CreateRow(data.id, data.product_name, price, cost, cost_type, qty);
                        $('#inputProduct').val('');
                        CountTotalPayment();
                        CountAmountedPayment();
                    }
                })
            }
        });

        function GetCustomer() {
            let value = '';
            let customer = 0;

            value = GetCustomerValue();

            if (value == 0) return {
                category_id: 0
            };

            $.ajax({
                url: "<?= site_url('Sales/getCustomer'); ?>",
                method: "POST",
                dataType: "json",
                data: {
                    id: value
                },
                async: false,
                success: function(data) {
                    customer = data;
                }
            })
            return customer;
        }

        function getDeliveryCost(costTypeId) {
            let cost;
            $.ajax({
                url: "<?= site_url('Sales/getDeliveryCost') ?>",
                method: "POST",
                dataType: "json",
                data: {
                    cost_type_id: costTypeId
                },
                async: false,
                success: function(response) {
                    cost = response.cost;
                },
                error: function(error) {
                    cost = 0;
                }
            });
            return parseInt(cost)
        }

        function CalculateCost(costTypeId = null, customerCategoryId) {
            if (customerCategoryId == '2') {
                return getDeliveryCost(costTypeId);
            } else {
                return 0;
            }
        }

        function UpdateRow() {
            const customer = GetCustomer();
            $('#sales-table tbody tr').each(function() {
                let extraPrice = parseInt($(this).find('td:nth-child(4) input#extra_price').val());
                let price = parseInt($(this).find('td:nth-child(3) input#price').val());
                let qty = parseInt($(this).find('td:nth-child(5) input#qty').val());
                let costTypeId = $(this).find('td:nth-child(3) input#cost-type').val()
                let cost = CalculateCost(costTypeId, customer.category_id);
                let inputCost = $(this).find('td:nth-child(3) input#cost');
                let spanTotalPrice = $(this).find('td:nth-child(3) span');
                let inputSubTotal = $(this).find('td:nth-child(6) input#sub-total');
                let spanSubTotal = $(this).find('td:nth-child(6) span');
                let inputExtraPrice = $(this).find('td:nth-child(4) input#extra_price');
                let totalPrice = price + cost;
                let subTotal = (totalPrice + extraPrice) * qty;
                inputCost.val(cost);
                inputExtraPrice.val(extraPrice);
                spanTotalPrice.html(toRupiah(totalPrice));
                inputSubTotal.val(subTotal);
                spanSubTotal.html(toRupiah(subTotal));
            })
        }

        $('#customers').change(function() {
            UpdateRow();
            CountTotalPayment();
            CountAmountedPayment();
        })

        function GetCustomerValue() {
            let value = '';
            $('#customers').each(function() {
                value = $(this).find('option:selected').val();
            })
            return value;
        }

        function GetPaymentMethodValue() {
            let value = '';
            $('#payment-method').each(function() {
                value = $(this).find('option:selected').val();
            })
            return value;
        }

        function GetDateTime() {
            const d = new Date();
            const date = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.toTimeString();
            return date;
        }

        $('#save-button').click(function() {

            let data = '';
            data += 'no_transaction=' + encodeURI($('#no-transaction').val());
            data += '&datetime=' + encodeURI(GetDateTime());
            data += '&user_id=' + encodeURI($('#user-id').val());
            data += '&customer_id=' + encodeURI(GetCustomerValue());
            data += '&total_payment=' + encodeURI(rupiahToInt($('#total-payment input').val()));
            data += '&payment_method=' + encodeURI(GetPaymentMethodValue());
            data += '&payment=' + encodeURI(rupiahToInt($('#amounted-payment').val()));
            data += '&change=' + encodeURI(rupiahToInt($('#change').val()));
            data += '&status=' + encodeURI($('#status').text());
            data += '&info=' + encodeURI($('#info').val());
            data += '&print=' + encodeURI($('#print-invoice:checked').val());
            data += '&' + $('#sales-table tbody input').serialize();

            console.table($('#sales-table tbody input').serialize());

            $.ajax({
                url: "<?= site_url('Sales/save'); ?>",
                method: "POST",
                data: data,
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.error == 'true') {
                        alert(response.message);
                    } else {
                        if (response.print == 'true') {
                            window.location.href = "<?= site_url('Sales/print?no_transaction='); ?>" + response.no_transaction + "&redirect=" + "<?= current_url() ?>"
                        } else {
                            location.reload();
                        }
                    }
                }
            })
        })



    });
</script>
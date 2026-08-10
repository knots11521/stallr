let stripe = null;
let elements = null;
let paymentElement = null;
let submitHandler = null;


/*
|--------------------------------------------------------------------------
| Initialize Stripe Payment Element
|--------------------------------------------------------------------------
*/

function initializeStripe(clientSecret, returnUrl) {

    if (!clientSecret) {
        console.warn('Stripe client secret is missing.');

        return;
    }


    const container =
        document.getElementById('payment-element');

    const button =
        document.getElementById('submit-payment');

    const message =
        document.getElementById('payment-message');


    if (!container || !button) {
        console.warn('Stripe payment elements not found.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy Previous Stripe Element
    |--------------------------------------------------------------------------
    */

    if (paymentElement) {

        paymentElement.destroy();

        paymentElement = null;
    }

    elements = null;


    /*
    |--------------------------------------------------------------------------
    | Remove Previous Submit Handler
    |--------------------------------------------------------------------------
    */

    if (submitHandler) {

        button.removeEventListener(
            'click',
            submitHandler
        );

        submitHandler = null;
    }


    /*
    |--------------------------------------------------------------------------
    | Create Stripe
    |--------------------------------------------------------------------------
    */

    stripe = Stripe(
        window.stripeKey
    );


    /*
    |--------------------------------------------------------------------------
    | Create Stripe Elements
    |--------------------------------------------------------------------------
    */

    elements = stripe.elements({
        clientSecret: clientSecret,
    });


    /*
    |--------------------------------------------------------------------------
    | Create Payment Element
    |--------------------------------------------------------------------------
    */

    paymentElement =
        elements.create('payment');


    /*
    |--------------------------------------------------------------------------
    | Mount Payment Element
    |--------------------------------------------------------------------------
    */

    paymentElement.mount(
        '#payment-element'
    );


    /*
    |--------------------------------------------------------------------------
    | Payment Element Ready
    |--------------------------------------------------------------------------
    */

    paymentElement.on('ready', () => {

        button.disabled = false;

        button.textContent =
            'Complete Payment';

    });


    /*
    |--------------------------------------------------------------------------
    | Payment Element Change
    |--------------------------------------------------------------------------
    */

    paymentElement.on('change', (event) => {

        if (!message) {
            return;
        }

        message.textContent =
            event.error?.message ?? '';

    });


    /*
    |--------------------------------------------------------------------------
    | Submit Payment
    |--------------------------------------------------------------------------
    */

    submitHandler = async () => {

        button.disabled = true;

        button.textContent =
            'Processing payment...';


        if (message) {
            message.textContent = '';
        }


        try {

            const result =
                await stripe.confirmPayment({

                    elements: elements,

                    confirmParams: {

                        return_url: returnUrl,

                    },

                });


            /*
            |--------------------------------------------------------------------------
            | Stripe Error
            |--------------------------------------------------------------------------
            */

            if (result.error) {

                if (message) {

                    message.textContent =
                        result.error.message ??
                        'Payment could not be completed.';

                }

                button.disabled = false;

                button.textContent =
                    'Complete Payment';
            }

        } catch (error) {

            console.error(
                'Stripe payment error:',
                error
            );


            if (message) {

                message.textContent =
                    'Something went wrong while processing your payment.';

            }


            button.disabled = false;

            button.textContent =
                'Complete Payment';
        }

    };


    button.addEventListener(
        'click',
        submitHandler
    );
}


/*
|--------------------------------------------------------------------------
| Livewire
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'livewire:init',
    () => {

        Livewire.on(
            'stripe-payment-ready',
            (event) => {

                initializeStripe(
                    event.clientSecret,
                    event.returnUrl
                );

            }
        );

    }
);

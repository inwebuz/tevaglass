@if($order)

    @php
        $progressBarStatusKeys = [
            \App\Models\Order::STATUS_COMPLETED,
            \App\Models\Order::STATUS_IN_DELIVERY,
            \App\Models\Order::STATUS_PROCESSING,
            \App\Models\Order::STATUS_PAID,
            \App\Models\Order::STATUS_PENDING,
        ];
        $dangerStatusKeys = [
            \App\Models\Order::STATUS_CANCELLED_AFTER_PAYMENT,
            \App\Models\Order::STATUS_CANCELLED,
        ];
    @endphp

    @if(in_array($order->status, $progressBarStatusKeys))
        <div class="my-4">
            <div class="inweb-progressbar">
                @foreach ($progressBarStatusKeys as $value)
                    <div class="inweb-progressbar-block @if($order->status == $value) active @endif">
                        <h4>{{ \App\Models\Order::statuses()[$value] }}</h4>
                        @if(!empty(\App\Models\Order::statusDescriptions()[$value]))
                            <p>{{ \App\Models\Order::statusDescriptions()[$value] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="my-4">
            <div class="inweb-progressbar">
                <div class="inweb-progressbar-block @if(in_array($order->status, $dangerStatusKeys)) inweb-progressbar-block-danger @else inweb-progressbar-block-info @endif active">
                    <h4>{{ $order->status_title }}</h4>
                    @if(!empty(\App\Models\Order::statusDescriptions()[$order->status]))
                        <p>{{ \App\Models\Order::statusDescriptions()[$order->status] }}</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endif

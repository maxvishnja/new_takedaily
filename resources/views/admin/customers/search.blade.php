@if(count($users) > 0)

@foreach($users as $user)

    @if($user->getCustomerId())
        <tr>
            <td>
                <a href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $user->getCustomerId() ]) }}">{{ $user->getCustomerId()}}</a>
            </td>
            <td>{{ $user->name }}</td>
            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            <td>
                {{ \Date::createFromFormat('Y-m-d H:i:s', $user->getCustomer()->created_at)->format('Y/m/d H:i')}}
            </td>
            <td>

                @if($user->customer->plan->getSubscriptionCancelledAt())
                    {{ \Date::createFromFormat('Y-m-d H:i:s', $user->customer->plan->getSubscriptionCancelledAt())->format('Y/m/d H:i') }}
                @else
                    No
                @endif
            </td>
            <td>
                @if($user->customer->plan->getRebillAt())
                    {{ \Date::createFromFormat('Y-m-d H:i:s', $user->customer->plan->getRebillAt())->format('Y/m/d H:i')}}
                @endif
            </td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-info" href="{{ URL::action('Dashboard\CustomerController@edit', [ 'id' => $user->customer->id ]) }}"><i class="icon-pencil"></i>
                    </a>

                    <a class="btn btn-default" href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $user->customer->id ]) }}"><i class="icon-eye-open"></i>
                        Vis</a>
                </div>
            </td>
        </tr>
    @endif
@endforeach

@endif

@if(count($customers) > 0)

    @foreach($customers as $customer)

        <tr>
            <td>
                <a href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $customer->id ]) }}">{{ $customer->id }}</a>
            </td>
            <td>{{ $customer->getName() }}</td>
            <td><a href="mailto:{{ $customer->getEmail() }}">{{ $customer->getEmail() }}</a></td>
            <td>
                {{ \Date::createFromFormat('Y-m-d H:i:s', $customer->created_at)->format('Y/m/d H:i')}}
            </td>
            <td>

                @if($customer->plan->getSubscriptionCancelledAt())
                    {{ \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getSubscriptionCancelledAt())->format('Y/m/d H:i') }}
                @else
                    No
                @endif
            </td>
            <td>
                @if($customer->plan->getRebillAt())
                    {{ \Date::createFromFormat('Y-m-d H:i:s', $customer->plan->getRebillAt())->format('Y/m/d H:i')}}
                @endif
            </td>
            <td>
                <div class="btn-group">
                    <a class="btn btn-info" href="{{ URL::action('Dashboard\CustomerController@edit', [ 'id' => $customer->id ]) }}"><i class="icon-pencil"></i>
                    </a>

                    <a class="btn btn-default" href="{{ URL::action('Dashboard\CustomerController@show', [ 'id' => $customer->id ]) }}"><i class="icon-eye-open"></i>
                        Vis</a>
                </div>
            </td>
        </tr>

    @endforeach

@endif
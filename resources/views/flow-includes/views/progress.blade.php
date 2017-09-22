<div class="flow-progress flow-progress--closed">

    <div id="flow-toggler"><span class="icon-arrow-down-lines"></span></div>

    <div>
        <nav class="nav-wizard">
           <li  v-bind:class="{ 'active': step === 1 }">
            <div class="flow-step" step="1"
                 v-bind:class="{ 'flow-step--inactive': step !== 1, 'flow-step--completed': step > 1 }">
                <div class="flow-step-progress">
						<span class="flow-step-progress-bar"
                              v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
                <div class="flow-step-check">
                    <div class="icon icon-check"></div>
                </div>
                <div class="flow-step-title">{{ trans('flow.steps.one') }}</div>
            </div>
           </li>
            <li  v-bind:class="{ 'active': step === 2 }">
            <div class="flow-step flow-step--inactive" step="2"
                 v-bind:class="{ 'flow-step--inactive': step !== 2, 'flow-step--completed': step > 2}">
                <div class="flow-step-progress">
						<span class="flow-step-progress-bar"
                              v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
                <div class="flow-step-check">
                    <div class="icon icon-check"></div>
                </div>
                <div class="flow-step-title">{{ trans('flow.steps.two') }}</div>
            </div>
            </li>
            <li v-bind:class="{ 'active': step === 3 }">
            <div class="flow-step flow-step--inactive" step="3"
                 v-bind:class="{ 'flow-step--inactive': step !== 3, 'flow-step--completed': step > 3 }">
                <div class="flow-step-progress">
						<span class="flow-step-progress-bar"
                              v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
                <div class="flow-step-check">
                    <div class="icon icon-check"></div>
                </div>
                <div class="flow-step-title">{{ trans('flow.steps.three') }}</div>
            </div>
            </li>
           <li v-bind:class="{ 'active': step === 4 }">
            <div class="flow-step flow-step--inactive" step="4"
                 v-bind:class="{ 'flow-step--inactive': step !== 4, 'flow-step--completed': step >= 4}">
                <div class="flow-step-progress">
                    <span class="flow-step-progress-bar" style="width: 100%"></span></div>
                <div class="flow-step-check">
                    <div class="icon icon-check"></div>
                </div>
                <div class="flow-step-title">{{ trans('flow.steps.four') }}</div>
            </div>
           </li>
        </nav>
    </div>
</div>
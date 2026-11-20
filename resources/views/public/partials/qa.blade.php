@if(!$qas->isEmpty())
<section class="py-5 qa-section">
    <div class="container">
       <div class="row">
           <div class="col-md-6">
               <h3 class="display-5 fw-bold mb-4 text-dark lh-13">
                   @lang('Hãy để <span class="text-primary">Proxy</span> giúp bạn trả lời những câu hỏi')
               </h3>
               <div class="text-center">
                   <img src="{{ asset('public/assets/images/frame_qa.png') }}" alt="">
               </div>
           </div>

           <div class="col-md-6">
               <div class="accordion" id="accordion-qa">
                   @foreach($qas as $index => $question)
                       <div class="accordion-item">
                           <h2 class="accordion-header" id="heading{{ $question->id }}">
                               <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                       type="button"
                                       data-bs-toggle="collapse"
                                       data-bs-target="#collapse{{ $question->id }}"
                                       aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                       aria-controls="collapse{{ $question->id }}">
                                   {{ $question->question }}
                               </button>
                           </h2>
                           <div id="collapse{{ $question->id }}"
                                class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $question->id }}"
                                data-bs-parent="#accordionExample">
                               <div class="accordion-body">
                                   {!! $question->answer !!}
                               </div>
                           </div>
                       </div>
                   @endforeach
               </div>
           </div>
       </div>
    </div>
</section>
@endif

@php
    $questions = App\Models\Question::orderBy('id', 'asc')->get();
@endphp
<section class="section section-bottom-0">
    <div class="container">
        <div class="section-head">
            <div class="row justify-content-center text-center">
                <div class="col-xl-8">
                    <h2 class="title">Frequently Asked Questions</h2>
                </div>
            </div>
        </div><!-- .section-head -->
        <div class="section-content">
            <div class="row g-gs justify-content-center">
                <div class="col-xl-9 col-xxl-8">
                    <div class="accordion accordion-flush accordion-plus-minus accordion-icon-accent" id="faq-1">
                        @foreach ($questions as $question)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-{{ '1-' . $question->id }}"> {{ $question->title }} </button>
                                </h2>
                                <div id="faq-{{ '1-' . $question->id }}" class="accordion-collapse collapse" data-bs-parent="#faq-{{ $question->id }}">
                                    <div class="accordion-body"> {{ $question->description }} </div>
                                </div>
                            </div><!-- .accordion-item -->
                        @endforeach
                    </div><!-- .accordion -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .section-content -->
    </div><!-- .container -->
</section><!-- .section -->
<div class="tabs-question w-tabs" data-duration-in="300" data-duration-out="100">
	<div class="div-question-tab-menu w-tab-menu">
		<a class="a-question-popup-tab w--current w-inline-block w-tab-link" id="a-question-popup-question-tab">
			<img class="img-tab" src="<?=base_url('images/question.png')?>">
			<div id="question-count"><?=$question->grid_position?></div>
		</a>
		<a class="a-question-popup-tab w-inline-block w-tab-link" id="a-question-popup-comment-tab">
			<img class="img-tab" src="<?=base_url('images/comment_1.png')?>">
			<div id="question-comment-count"><?=count($question->question_comments)?></div>
		</a>
	</div>
	<div class="w-tab-content">
		<div class="tab-pane-question-popup w--tab-active w-tab-pane" id="tab-question-popup-question">
			<div class="div-qna-wrapper">
				<div class="div-question-wrapper">
					<div class="div-qna-header">
						<div class="div-qna-title">
							<h5 class="h-qna-title"><?=$question->grid_position?>. Question</h5>
						</div>
						<div class="div-qna-toolbar icon-wrapper question w-clearfix">
							<img class="img-qna-tool" id="add-bullet-point" src="<?=base_url('images/bullet-points-small.png')?>" width="20">
							<img class="img-qna-tool" id="add-image" src="<?=base_url('images/image-small.png')?>" width="20">
							<img class="img-qna-tool" id="delete-question" src="<?=base_url('images/delete-black.png')?>" width="20">
							<img class="img-qna-tool" id="add-sub-question" src="<?=base_url('images/plus-s.png')?>" width="20">
						</div>
					</div>
					<div class="form-block-question w-form">
						<form class="div-qna-form question" data-name="Email Form" id="email-form" name="email-form">
							<textarea class="question text-area-qna w-input" data-name="Question Text 10" id="question-text-10" maxlength="5000" name="question-text-10" placeholder="Enter question..."><?=$question->question?></textarea>
						</form>
						<!--<div class="w-form-done">
							<div>Thank you! Your submission has been received!</div>
						</div>
						<div class="w-form-fail">
							<div>Oops! Something went wrong while submitting the form</div>
						</div>-->
					</div>
				</div>
				<div class="div-answer-wrapper ready-answer">
					<div class="answer div-qna-toolbar icon-wrapper w-clearfix">
						<img class="img-qna-tool" id="add-bullet-point" src="<?=base_url('images/bullet-points-small.png')?>" width="20">
						<img class="img-qna-tool" id="add-image" src="<?=base_url('images/image-small.png')?>" width="20">
						<img class="img-qna-tool" id="delete-question" src="<?=base_url('images/delete-black.png')?>" width="20">
					</div>
					<div class="div-qna-header ready-answer">
						<div class="div-qna-title">
							<h5 class="h-qna-title"><?=$question->grid_position?>. Answer</h5>
						</div>
					</div>
					<div class="form-block-answer w-form">
						<form class="answer div-qna-form" data-name="Email Form" id="email-form" name="email-form">
							<textarea class="answer text-area-qna w-input" data-name="Answer Text 3" id="answer-text-3" maxlength="5000" name="answer-text-3" placeholder="Enter answer..."><?=$question->answer?></textarea>
						</form>
						<!--<div class="w-form-done">
							<div>Thank you! Your submission has been received!</div>
						</div>
						<div class="w-form-fail">
							<div>Oops! Something went wrong while submitting the form</div>
						</div>-->
					</div>
				</div>
			</div>
			<?php if ( ! empty($question->subquestions)): ?>
				<?php foreach ($question->subquestions as $subquestion): ?>
					<div class="div-qna-wrapper">
						<div class="div-question-wrapper">
							<div class="div-qna-header">
								<div class="div-qna-title">
									<h5 class="h-qna-title">#.#. Question</h5>
								</div>
								<div class="div-qna-toolbar icon-wrapper question w-clearfix">
									<img class="img-qna-tool" id="add-bullet-point" src="<?=base_url('images/bullet-points-small.png')?>" width="20">
									<img class="img-qna-tool" id="add-image" src="<?=base_url('images/image-small.png')?>" width="20">
									<img class="img-qna-tool" id="delete-question" src="<?=base_url('images/delete-black.png')?>" width="20">
									<img class="img-qna-tool" id="add-sub-question" src="<?=base_url('images/plus-s.png')?>" width="20">
								</div>
							</div>
							<div class="form-block-question w-form">
								<form class="div-qna-form question" data-name="Email Form" id="email-form" name="email-form">
									<textarea class="question text-area-qna w-input" data-name="Question Text 2" id="question-text-2" maxlength="5000" name="question-text-2" placeholder="Enter question..."></textarea>
								</form>
								<!--<div class="w-form-done">
									<div>Thank you! Your submission has been received!</div>
								</div>
								<div class="w-form-fail">
									<div>Oops! Something went wrong while submitting the form</div>
								</div>-->
							</div>
						</div>
						<div class="div-answer-wrapper">
							<div class="div-qna-header enter-answer">
								<div class="answer div-qna-toolbar icon-wrapper w-clearfix">
									<img class="img-qna-tool" id="add-bullet-point" src="<?=base_url('images/bullet-points-small.png')?>" width="20">
									<img class="img-qna-tool" id="add-image" src="<?=base_url('images/image-small.png')?>" width="20">
									<img class="img-qna-tool" id="delete-question" src="<?=base_url('images/delete-black.png')?>" width="20">
								</div>
								<div class="div-qna-title">
									<h5 class="h-qna-title">5.1. Answer</h5>
								</div>
							</div>
							<div class="form-block-answer w-form">
								<form class="answer div-qna-form" data-name="Email Form" id="email-form" name="email-form"><textarea class="answer text-area-qna w-input" data-name="Answer Text 2" id="answer-text-2" maxlength="5000" name="answer-text-2" placeholder="Enter answer..."></textarea></form>
								<!--<div class="w-form-done">
									<div>Thank you! Your submission has been received!</div>
								</div>
								<div class="w-form-fail">
									<div>Oops! Something went wrong while submitting the form</div>
								</div>-->
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="tab-pane-question-popup w-tab-pane" id="tab-question-popup-comment">
			<div class="comment form-block-question w-form">
				<form class="div-qna-form" data-name="Email Form" id="wf-form-Email-Form" name="wf-form-Email-Form">
					<textarea class="question text-area-qna w-input" data-name="Question Text 3" id="question-text-3" maxlength="5000" name="question-text-3" placeholder="Enter comment..."></textarea>
				</form>
				<!--<div class="w-form-done">
					<div>Thank you! Your submission has been received!</div>
				</div>
				<div class="w-form-fail">
					<div>Oops! Something went wrong while submitting the form</div>
				</div>-->
			</div>
			<div class="div-qna-header">
				<h5 class="h-qna-title">Comments</h5>
				<div class="form-block-comment-sort w-form">
					<form data-name="Email Form 2" id="email-form-2" name="email-form-2">
						<select class="select-field-comment-sort w-select" data-name="Select Comment Filter 2" id="select-comment-filter-2" name="select-comment-filter-2">
							<option value="most-recent">Most Recent</option>
							<option value="best-rated">Best Rated</option>
						</select>
					</form>
					<!--<div class="w-form-done">
						<div>Thank you! Your submission has been received!</div>
					</div>
					<div class="w-form-fail">
						<div>Oops! Something went wrong while submitting the form</div>
					</div>-->
				</div>
			</div>
			<div class="div-question-comment-wrapper">
				<div class="div-qna-header">
					<div class="text-question-comment-author">pauldstar</div>
					<div class="div-qna-toolbar icon-wrapper question w-clearfix">
						<img class="img-qna-tool" src="<?=base_url('images/edit-black.png')?>">
						<img class="img-qna-tool" id="delete-question" src="<?=base_url('images/delete-black.png')?>" width="20">
					</div>
					<div class="div-vote-count-wrapper">
						<div class="div-vote-click-wrapper">
							<div class="text-vote-count" id="upvote-count">122846</div>
							<img class="img-vote-count" src="<?=base_url('images/up-arrow.png')?>">
						</div>
						<div class="div-vote-click-wrapper">
							<div class="text-vote-count" id="upvote-count">4543</div>
							<img class="img-vote-count" src="<?=base_url('images/down-arrow-black.png')?>">
						</div>
					</div>
				</div>
				<div class="form-block-question w-form">
					<form class="div-qna-form question" data-name="Email Form" id="email-form" name="email-form"><textarea class="comment text-area-qna w-input" data-name="Question Text 4" id="question-text-4" maxlength="5000" name="question-text-4" placeholder="Enter question..."></textarea></form>
					<!--<div class="w-form-done">
						<div>Thank you! Your submission has been received!</div>
					</div>
					<div class="w-form-fail">
						<div>Oops! Something went wrong while submitting the form</div>
					</div>-->
				</div>
			</div>
			<div class="div-question-comment-wrapper">
				<div class="div-qna-header">
					<div class="text-question-comment-author">jinn</div>
					<div class="div-qna-toolbar icon-wrapper question w-clearfix"><img class="img-qna-tool" src="<?=base_url('images/edit-black.png')?>"><img class="img-qna-tool" id="delete-question" src="<?=base_url('images/delete-black.png')?>" width="20"></div>
					<div class="div-vote-count-wrapper">
						<div class="div-vote-click-wrapper">
							<div class="text-vote-count" id="upvote-count">325</div>
							<img class="img-vote-count" src="<?=base_url('images/up-arrow.png')?>">
						</div>
						<div class="div-vote-click-wrapper">
							<div class="text-vote-count" id="upvote-count">4543</div>
							<img class="img-vote-count" src="<?=base_url('images/down-arrow-black.png')?>">
						</div>
					</div>
				</div>
				<div class="form-block-question w-form">
					<form class="div-qna-form question" data-name="Email Form" id="email-form" name="email-form"><textarea class="comment text-area-qna w-input" data-name="Question Text 9" id="question-text-9" maxlength="5000" name="question-text-9" placeholder="Enter question..."></textarea></form>
					<!--<div class="w-form-done">
						<div>Thank you! Your submission has been received!</div>
					</div>
					<div class="w-form-fail">
						<div>Oops! Something went wrong while submitting the form</div>
					</div>-->
				</div>
			</div>
		</div>
	</div>
</div>
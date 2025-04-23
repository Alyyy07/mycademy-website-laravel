@extends('layouts.partials.admin.app')

@section('content')
<!--begin::Content-->
<div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
	<!--begin::Messenger-->
	<div class="card" id="kt_chat_messenger">
		<div class="card-header d-flex justify-content-between align-items-center border-0 pt-6">
			<a href="{{ route('forum-diskusi.detail', ['id' => $rpsMatakuliahId]) }}"
				class="btn btn-light me-3">Kembali</a>
			@if(!$materi->rpsDetail->close_forum && Auth::user()->roles->first()->name === 'dosen')
			<button type="button" class="btn btn-light-danger tutup-forum-btn" data-id="{{ $materi->rpsDetail->id }}">
				<i class="ki-outline ki-check fs-2"></i> Tutup Forum Diskusi
			</button>
			@endif
		</div>

		<div class="card-header" id="kt_chat_messenger_header">
			<div class="card-title">
				<div class="d-flex justify-content-center flex-column me-3">
					<div class="fs-4 fw-bold text-gray-900 me-1 my-2 lh-1">Materi : {{ $materi->title }}</div>
					<div class="text-muted fw-semibold fs-7">Pertemuan Ke - {{ $materi->rpsDetail->sesi_pertemuan }}
					</div>
				</div>
			</div>
		</div>

		<div class="card-body" id="kt_chat_messenger_body">
			<div class="scroll-y me-n5 pe-5 h-300px h-lg-auto messages-body" data-kt-element="messages"
				data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
				data-kt-scroll-max-height="auto"
				data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
				data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
				data-kt-scroll-offset="5px">

				@if ($discussionMessages->isEmpty())
				<div class="d-flex p-6 mb-10">
					<div class="d-flex justify-content-center flex-grow-1">
						<div class="fs-6 text-gray-700 fw-semibold">Belum ada Diskusi di Materi ini !</div>
					</div>
				</div>
				@endif

				@foreach ($discussionMessages as $message)
				@php
				$photo_path = $message->sender->profile_photo ?? 'image/profile-photo/blank.png';
				@endphp

				@if ($message->sender_id === auth()->user()->id)
				<div class="d-flex justify-content-end mb-10">
					<div class="d-flex flex-column align-items-end">
						<div class="d-flex align-items-center mb-2">
							<div class="me-3 text-end">
								<div><span class="text-muted fs-7 mb-1 me-3">{{ $message->created_at->diffForHumans()
										}}</span>
									<span class="fs-5 fw-bold text-gray-900 ms-1">Anda</span>
								</div>
								<div class="badge badge-sm badge-light-info">{{ ucwords(str_replace('-', ' ',
									$message->sender->roles->first()->name)) }}</div>
							</div>
							<div class="symbol symbol-45px symbol-circle">
								<img alt="Pic" src="{{ asset("storage/$photo_path") }}" />
							</div>
						</div>
						<div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
							data-kt-element="message-text">
							{{ $message->message }}
						</div>
					</div>
				</div>
				@else
				<div class="d-flex justify-content-start mb-10">
					<div class="d-flex flex-column align-items-start">
						<div class="d-flex align-items-center mb-2">
							<div class="symbol symbol-45px symbol-circle">
								<img alt="Pic" src="{{ asset("storage/$photo_path") }}" />
							</div>
							<div class="ms-3">
								<div>
									<span class="fs-5 fw-bold text-gray-900 me-1">{{
										$message->sender->name }}</span>
									<span class="text-muted fs-7 mb-1">{{ $message->created_at->diffForHumans()
										}}</span>
								</div>
								<div class="badge badge-sm badge-light-info">{{ str_replace('-', ' ',
									$message->sender->roles->first()->name) }}</div>
							</div>
						</div>
						<div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
							data-kt-element="message-text">
							{{ $message->message }}
						</div>
					</div>
				</div>
				@endif
				@endforeach

			</div>
		</div>

		<div class="card-footer pt-4" id="kt_chat_messenger_footer">
			<textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input"
				placeholder="Type a message"></textarea>
			<div class="d-flex justify-content-end">
				<button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector('[data-kt-element="input"]');
    const sendButton = document.querySelector('[data-kt-element="send"]');
    const messageContainer = document.querySelector('.messages-body');

    sendButton.addEventListener('click', function () {
        let message = input.value.trim();
        if (message === '') return;

        sendButton.setAttribute('disabled', true);
        sendButton.innerHTML = 'Mengirim...';

        fetch("{{ route('forum-diskusi.messages.store', $materi->id) }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let formattedRole = '';
                if (data.role) {
                    formattedRole = data.role.replace(/-/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
                }
                const html = `
                    <div class="d-flex justify-content-end mb-10">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3 text-end">
                                    <div><span class="text-muted fs-7 mb-1 me-3">Baru saja</span><span class="fs-5 fw-bold text-gray-900 ms-1">Anda</span></div>
                                    <div class="badge badge-sm badge-light-info">${formattedRole}</div>
                                </div>
                                <div class="symbol symbol-45px symbol-circle">
                                    <img alt="Pic" src="{{ asset('storage/') }}/${data.photo}" />
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">${data.content}</div>
                        </div>
                    </div>
                `;
                messageContainer.insertAdjacentHTML('beforeend', html);
				lastMessageIds.add(data.id);
                input.value = '';
                messageContainer.scrollTop = messageContainer.scrollHeight;
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            sendButton.removeAttribute('disabled');
            sendButton.innerHTML = 'Send';
        });
    });

	document.querySelector('.tutup-forum-btn')?.addEventListener('click', function () {
		const rpsDetailId = this.dataset.id;
        Swal.fire({
            title: 'Tutup Forum Diskusi?',
            text: "Setelah dikonfirmasi, forum ini akan diakhiri dan tidak dapat diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Akhiri!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('modul-pembelajaran.end-forum') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ rps_detail_id: rpsDetailId })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
							window.location.href = data.redirect_url
                        }
                    });
                });
            }
        });
	});

    // Polling logic
    let lastMessageIds = new Set();
    const assetBaseUrl = "{{ asset('storage') }}";

    function pollMessages() {
        fetch("{{ route('forum-diskusi.messages', $materi->id) }}")
        .then(response => response.json())
        .then(messages => {
            messages.forEach(data => {
                if (!lastMessageIds.has(data.id)) {
                    lastMessageIds.add(data.id);

                    const isCurrentUser = data.sender_id === parseInt("{{ auth()->id() }}");
                    const formattedRole = data.role.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

                    const html = `
                        <div class="d-flex ${isCurrentUser ? 'justify-content-end' : 'justify-content-start'} mb-10">
                            <div class="d-flex flex-column align-items-${isCurrentUser ? 'end' : 'start'}">
                                <div class="d-flex align-items-center mb-2">
                                    ${!isCurrentUser ? `<div class="symbol symbol-45px symbol-circle"><img alt="Pic" src="${assetBaseUrl}/${data.photo}" /></div>` : ''}
                                    <div class="${isCurrentUser ? 'me-3 text-end' : 'ms-3'}">
                                        <div><span class="fs-5 fw-bold text-gray-900 me-1">${isCurrentUser ? 'Anda' : data.name}</span><span class="text-muted fs-7 mb-1">${data.created_at}</span></div>
                                        <div class="badge badge-sm badge-light-info">${formattedRole}</div>
                                    </div>
                                    ${isCurrentUser ? `<div class="symbol symbol-45px symbol-circle"><img alt="Pic" src="${assetBaseUrl}/${data.photo}" /></div>` : ''}
                                </div>
                                <div class="p-5 rounded ${isCurrentUser ? 'bg-light-primary text-end' : 'bg-light-info text-start'} text-dark fw-semibold mw-lg-400px" data-kt-element="message-text">${data.content}</div>
                            </div>
                        </div>`;
                    messageContainer.insertAdjacentHTML('beforeend', html);
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                }
            });
        });
    }

    setInterval(pollMessages, 5000);
});
</script>
@endpush
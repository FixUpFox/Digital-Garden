document.addEventListener('DOMContentLoaded', function () {
	const noteItems = document.querySelectorAll('.digital-garden-note-item');
	const params = new URLSearchParams(window.location.search);
	const selectedTags = params.get('tags')
		? params.get('tags').split(',').map(Number)
		: [];

	// Check if current page has body class of single-note
	if (document.body.classList.contains('single-note')) {
		// Add current note to local storage
		addCurrentNoteToLocalStorage({
			title: document.querySelectorAll('.wp-block-post-title')[0]
				.textContent,
			url: window.location.href,
		});
	}

	// Update URL with a query string for selected tags
	function updateURL() {
		const urlParams = new URLSearchParams(window.location.search);
		if (selectedTags.length > 0) {
			urlParams.set('tags', selectedTags.join(','));
		} else {
			urlParams.delete('tags');
		}
		window.history.replaceState(
			{},
			'',
			`${window.location.pathname}?${urlParams}`
		);
	}

	// Filter notes based on selected tags
	function filterNotes() {
		if (selectedTags.length > 0) {
			noteItems.forEach((item) => {
				const tags = JSON.parse(item.getAttribute('data-tag-ids'));
				const isMatch = tags.some((tag) => selectedTags.includes(tag));
				item.style.display = isMatch ? '' : 'none';
			});
		} else {
			noteItems.forEach((item) => (item.style.display = ''));
		}
	}

	// Function to handle hover modal
	function handleHoverModal(link) {
		const noteId = link.getAttribute('data-note-id');
		if (!noteId) {
			return;
		} // Exit if data-note-id is not found

		const modal = document.createElement('div');
		modal.classList.add('digital-garden-modal');
		modal.innerHTML = '<div class="modal-content">Loading...</div>';
		document.body.appendChild(modal);

		fetch(digitalGardenData.ajax_url, {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type':
					'application/x-www-form-urlencoded; charset=UTF-8',
			},
			body:
				'action=digital_garden_fetch_note_excerpt&note_id=' +
				noteId +
				'&nonce=' +
				encodeURIComponent(digitalGardenData.nonce),
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success && data.data && data.data.content) {
					const content = data.data.content;
					modal.querySelector('.modal-content').innerHTML =
						'<strong>' +
						decodeHtml(content.title) +
						'</strong><br>' +
						decodeHtml(content.excerpt);
				} else {
					modal.querySelector('.modal-content').innerHTML =
						'Error loading note data.';
				}
			})
			.catch((error) => {
				console.error('Error fetching note data:', error); // Debugging log
				modal.querySelector('.modal-content').innerHTML =
					'Error loading note data.';
			});

		const rect = link.getBoundingClientRect();
		modal.style.top = `${rect.top + window.scrollY + rect.height}px`;
		modal.style.left = `${rect.left + window.scrollX}px`;

		link.addEventListener('mouseleave', function () {
			const existingModal = document.querySelector(
				'.digital-garden-modal'
			);
			if (existingModal) {
				existingModal.remove();
			}
		});
	}

	// Add event listeners for note link hover to display modal
	const noteLinksSelector =
		'.digital-garden-note-link, .digital-garden-regular-link';
	const links = document.querySelectorAll(noteLinksSelector);

	links.forEach((link) => {
		link.addEventListener('mouseenter', function () {
			handleHoverModal(this);
		});
	});

	// Function to decode HTML entities
	function decodeHtml(str) {
		const textarea = document.createElement('textarea');
		textarea.innerHTML = str;
		return textarea.value;
	}

	// Function to add current note to local storage
	function addCurrentNoteToLocalStorage(note) {
		const notes = localStorage.getItem('digitalGardenNotes')
			? JSON.parse(localStorage.getItem('digitalGardenNotes'))
			: [];

		// Check if the note already exists in the array
		const existingNoteIndex = notes.findIndex(
			(n) => n.title === note.title && n.url === note.url
		);

		if (existingNoteIndex > -1) {
			// If the note exists, remove it from the array
			notes.splice(existingNoteIndex, 1);
		}

		// Add the note to the notes array
		notes.push(note);

		// Limit the number of notes to digitalGardenData.max_steps
		if (notes.length > digitalGardenData.max_steps) {
			notes.shift();
		}

		localStorage.setItem('digitalGardenNotes', JSON.stringify(notes));
	}

	function displayRecentNotes() {
		// return if the div is not present.
		if (
			!document.querySelector('.digital-garden-breadcrumbs-placeholder')
		) {
			return;
		}

		const notes = localStorage.getItem('digitalGardenNotes')
			? JSON.parse(localStorage.getItem('digitalGardenNotes'))
			: [];

		// Get the div with the class digital-garden-breadcrumbs-placeholder
		const recentNotesContainer = document.querySelector(
			'.digital-garden-breadcrumbs-placeholder'
		);

		// If the div is not found, exit the function
		if (!recentNotesContainer) {
			return;
		}

		// change the class on the div
		recentNotesContainer.className = 'digital-garden-breadcrumbs';

		let recentNotesContent =
			'<div class="digital-garden-breadcrumb-title">Recently Viewed Notes</div><ul>';

		if (notes.length > 0) {
			notes.forEach((note) => {
				recentNotesContent += `<li><a href="${note.url}" class="digital-garden-regular-link">${note.title}</a></li>`;
			});
		}

		recentNotesContent += '</ul>';

		recentNotesContainer.innerHTML = recentNotesContent;
	}
});

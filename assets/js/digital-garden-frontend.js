document.addEventListener('DOMContentLoaded', function () {
	const noteItems = document.querySelectorAll('.digital-garden-note-item');
	const tagButtons = document.querySelectorAll('.digital-garden-tag-button');
	const clearButton = document.createElement('button');
	const params = new URLSearchParams(window.location.search);
	let selectedTags = params.get('tags') ? params.get('tags').split(',').map(Number) : [];

	// Check if current page has body class of single-note
	if (document.body.classList.contains('single-note')) {
		// Add current note to local storage
		addCurrentNoteToLocalStorage({
			title: document.querySelectorAll('.wp-block-post-title')[0].textContent,
			url: window.location.href,
		});
	}

	clearButton.textContent = 'Clear Tags';
	clearButton.className = 'digital-garden-clear-button';

	// Append the clear button after the last tag button
	if (tagButtons.length > 0) {
		tagButtons[tagButtons.length - 1].parentNode.appendChild(clearButton);
	}

	// Add event listeners to tag buttons
	tagButtons.forEach(button => {
		button.addEventListener('click', function () {
			const tagId = parseInt(this.getAttribute('data-tag-id'));
			const index = selectedTags.indexOf(tagId);
			if (index > -1) {
				// Remove tag from array
				selectedTags.splice(index, 1);
				this.classList.remove('active');
			} else {
				// Add tag to array
				selectedTags.push(tagId);
				this.classList.add('active');
			}
			updateURL();
			filterNotes();
		});
	});

	// Clear all selected tags
	clearButton.addEventListener('click', function () {
		selectedTags = [];
		tagButtons.forEach(button => button.classList.remove('active'));
		noteItems.forEach(item => item.style.display = '');
		updateURL();
	});

	// Update URL with a query string for selected tags
	function updateURL() {
		const params = new URLSearchParams(window.location.search);
		if (selectedTags.length > 0) {
			params.set('tags', selectedTags.join(','));
		} else {
			params.delete('tags');
		}
		window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
	}

	// Ensures that tags in query string are filtered on page load
	selectedTags.forEach(tag => {
		const tagElement = document.querySelector(`.digital-garden-tag-button[data-tag-id="${tag}"]`);
		if (tagElement) {
			tagElement.classList.add('active');
		}
		filterNotes();
	});

	// Filter notes based on selected tags
	function filterNotes() {
		if (selectedTags.length > 0) {
			noteItems.forEach(item => {
				const tags = JSON.parse(item.getAttribute('data-tag-ids'));
				const isMatch = tags.some(tag => selectedTags.includes(tag));
				item.style.display = isMatch ? '' : 'none';
			});
		} else {
			noteItems.forEach(item => item.style.display = '');
		}
	}

	// Function to handle hover modal
	function handleHoverModal(link) {
		const noteId = link.getAttribute('data-note-id');
		if (!noteId) return;  // Exit if data-note-id is not found

		const modal = document.createElement('div');
		modal.classList.add('digital-garden-modal');
		modal.innerHTML = '<div class="modal-content">Loading...</div>';
		document.body.appendChild(modal);

		fetch(digitalGardenData.ajax_url, {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'action=digital_garden_fetch_note_excerpt&note_id=' + noteId + '&nonce=' + encodeURIComponent(digitalGardenData.nonce)
		})
			.then(response => response.json())
			.then(data => {
				if (data.success && data.data && data.data.content) {
					const content = data.data.content;
					modal.querySelector('.modal-content').innerHTML = '<strong>' + decodeHtml(content.title) + '</strong><br>' + decodeHtml(content.excerpt);
				} else {
					modal.querySelector('.modal-content').innerHTML = 'Error loading note data.';
				}
			})
			.catch(error => {
				console.error('Error fetching note data:', error); // Debugging log
				modal.querySelector('.modal-content').innerHTML = 'Error loading note data.';
			});

		const rect = link.getBoundingClientRect();
		modal.style.top = `${rect.top + window.scrollY + rect.height}px`;
		modal.style.left = `${rect.left + window.scrollX}px`;

		link.addEventListener('mouseleave', function () {
			const modal = document.querySelector('.digital-garden-modal');
			if (modal) {
				modal.remove();
			}
		});
	}

	// Add event listeners for note link hover to display modal
	const noteLinksSelector = '.digital-garden-note-link, .digital-garden-regular-link';
	const links = document.querySelectorAll(noteLinksSelector);

	links.forEach(link => {
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
		let notes = localStorage.getItem('digitalGardenNotes') ? JSON.parse(localStorage.getItem('digitalGardenNotes')) : [];

		// If the notes array already has this note, remove it.
		if (notes.includes(note)) {
			notes = notes.filter(item => item !== note);
			localStorage.setItem('digitalGardenNotes', JSON.stringify(notes));
		}

		// Add the note to the notes array
		notes.push(note);
		localStorage.setItem('digitalGardenNotes', JSON.stringify(notes));
	}

});

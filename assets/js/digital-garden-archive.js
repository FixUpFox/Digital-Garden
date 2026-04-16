(function () {
	/**
	 * Safely parse a JSON string and return a fallback value on failure.
	 *
	 * @param {string}              value
	 * @param {Array|string|Object} fallback
	 * @return {Array|string|Object}
	 */
	function parseJSON(value, fallback) {
		if (!value) {
			return fallback;
		}

		try {
			const parsed = JSON.parse(value);
			return parsed || fallback;
		} catch (error) {
			return fallback;
		}
	}

	/**
	 * Initialise interactive behaviour for a single container.
	 *
	 * @param {HTMLElement} container
	 */
	function initialiseContainer(container) {
		if (!container) {
			return;
		}

		const noteBlock = container.querySelector('.digital-garden-note-block');
		if (!noteBlock) {
			return;
		}

		const notes = Array.from(
			noteBlock.querySelectorAll('.digital-garden-note'),
		);
		if (!notes.length) {
			return;
		}

		const tagInputs = Array.from(
			container.querySelectorAll(
				'.digital-garden-filter-input[data-filter-type="tag"]',
			),
		);
		const completenessSelect = container.querySelector(
			'.digital-garden-completeness-filter .digital-garden-filter-select',
		);
		const activeFilterRoot = container.querySelector(
			'.digital-garden-active-filter',
		);
		const orderSelect = activeFilterRoot
			? activeFilterRoot.querySelector('.digital-garden-active-filter__select')
			: null;
		const emptyState = noteBlock.querySelector(
			'.digital-garden-note-block__empty',
		);

		let defaultOrder = 'published';
		if (orderSelect && orderSelect.value) {
			defaultOrder = orderSelect.value;
		}

		const state = {
			tags: new Set(),
			completeness: completenessSelect ? completenessSelect.value : '',
			order: defaultOrder,
			defaultOrder,
		};

		function setFilterButtonState(input) {
			const button = input.closest('.digital-garden-filter-button');
			if (!button) {
				return;
			}

			button.classList.toggle('is-active', input.checked);
		}

		function updateFilterUI() {
			const hasFilters =
				state.tags.size > 0 ||
				(!!state.completeness && state.completeness !== '') ||
				state.order !== state.defaultOrder;

			container.dataset.activeFilters = hasFilters ? '1' : '0';
		}

		function updateOrderControl() {
			if (orderSelect) {
				orderSelect.value = state.order;
			}
		}

		function applySort() {
			if (!noteBlock || !notes.length) {
				return;
			}

			const sorted = notes.slice().sort((a, b) => {
				const key = state.order === 'modified' ? 'modified' : 'published';
				const aValue = parseInt(a.dataset[key] || '0', 10);
				const bValue = parseInt(b.dataset[key] || '0', 10);
				return bValue - aValue;
			});

			sorted.forEach((note) => {
				if (emptyState) {
					noteBlock.insertBefore(note, emptyState);
				} else {
					noteBlock.appendChild(note);
				}
			});
		}

		function setSort(order) {
			if (!order) {
				return;
			}

			if (order !== state.order) {
				state.order = order;
			}

			updateOrderControl();
			applySort();
			updateFilterUI();
		}

		function applyFilters() {
			const activeTags = Array.from(state.tags);
			let visibleCount = 0;

			notes.forEach((note) => {
				const noteTags = parseJSON(note.dataset.tags, []);
				const noteCompleteness = note.dataset.completeness || '';
				const matchesTags =
					!activeTags.length ||
					activeTags.every((tag) => noteTags.includes(tag));
				const matchesCompleteness =
					!state.completeness ||
					state.completeness === '' ||
					state.completeness === noteCompleteness;

				if (matchesTags && matchesCompleteness) {
					note.style.display = '';
					note.dataset.visible = '1';
					visibleCount += 1;
				} else {
					note.style.display = 'none';
					delete note.dataset.visible;
				}
			});

			if (emptyState) {
				emptyState.hidden = visibleCount !== 0;
			}

			updateFilterUI();
			applySort();
		}

		function handleCheckboxChange(event) {
			const input = event.target;
			const value = input.value;
			const filterType = input.dataset.filterType;

			if (!value || !filterType || filterType !== 'tag') {
				return;
			}

			const collection = state.tags;

			if (input.checked) {
				collection.add(value);
			} else {
				collection.delete(value);
			}

			setFilterButtonState(input);
			applyFilters();
		}

		tagInputs.forEach((input) => {
			input.addEventListener('change', handleCheckboxChange);
			setFilterButtonState(input);

			if (input.checked && input.value) {
				state.tags.add(input.value);
			}
		});

		if (completenessSelect) {
			completenessSelect.addEventListener('change', () => {
				state.completeness = completenessSelect.value || '';
				applyFilters();
			});
		}

		if (orderSelect) {
			orderSelect.addEventListener('change', () => {
				const order = orderSelect.value || state.defaultOrder;
				setSort(order);
			});
		}

		updateOrderControl();
		applyFilters();
	}

	document.addEventListener('DOMContentLoaded', () => {
		const containers = document.querySelectorAll('.digital-garden-container');
		if (!containers.length) {
			return;
		}

		containers.forEach(initialiseContainer);
	});
})();

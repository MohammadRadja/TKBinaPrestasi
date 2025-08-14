document.addEventListener("DOMContentLoaded", () => {
    // ==============================
    // 🔹 MODULE: SweetAlert Helper
    // ==============================
    const Alert = {
        success: (message) => {
            Swal.fire({
                title: "Berhasil!",
                text: message || "Operasi berhasil",
                icon: "success",
                showConfirmButton: false,
                timer: 1200,
                timerProgressBar: true,
            }).then(() => location.reload());
        },
        error: (message) => {
            Swal.fire({
                title: "Gagal!",
                text: message || "Terjadi kesalahan saat memproses",
                icon: "error",
                confirmButtonColor: "#d33",
            });
        },
        warning: (message) => {
            Swal.fire({
                title: "Peringatan!",
                text: message || "Periksa kembali data Anda",
                icon: "warning",
                confirmButtonColor: "#f0ad4e",
            });
        },
        listWarning: (errors) => {
            Swal.fire({
                title: "Terjadi Kesalahan",
                icon: "warning",
                html: errors.map((e) => `<div>• ${e}</div>`).join(""),
                confirmButtonColor: "#f0ad4e",
            });
        },
    };

    // ==============================
    // 🔹 MODULE: CRUD Modal
    // ==============================
    const CrudModal = (() => {
        let modal, modalTitle, modalBody, crudForm, crudSaveBtn;
        let currentUrl = "",
            currentMethod = "POST";
        let isDeleteAction = false,
            isApproveAction = false,
            isRejectAction = false;

        const initElements = () => {
            const modalElement = document.getElementById("crudModal");
            modal = modalElement ? new bootstrap.Modal(modalElement) : null;
            modalTitle = document.getElementById("crudModalTitle");
            modalBody = document.getElementById("crudModalBody");
            crudForm = document.getElementById("crudForm");
            crudSaveBtn = document.getElementById("crudSaveBtn");
        };

        const buildForm = (fields, preset = {}) => {
            return Object.entries(fields)
                .map(([name, field]) => {
                    const label = field.label || name;
                    const type = field.type || "text";
                    const value = preset[name] ?? "";
                    const placeholder = field.placeholder || "";
                    const hint = field.hint
                        ? `<small class="form-text text-muted">${field.hint}</small>`
                        : "";

                    if (type === "select") {
                        const options = [
                            `<option value="">${
                                placeholder || "-- Pilih --"
                            }</option>`,
                            ...(Array.isArray(field.options)
                                ? field.options.map(
                                      (opt) =>
                                          `<option value="${opt}" ${
                                              opt == value ? "selected" : ""
                                          }>${opt}</option>`
                                  )
                                : Object.entries(field.options || {}).map(
                                      ([val, text]) =>
                                          `<option value="${val}" ${
                                              val == value ? "selected" : ""
                                          }>${text}</option>`
                                  )),
                        ];
                        return `<div class="mb-3">
                        <label>${label}</label>
                        <select name="${name}" class="form-select">${options.join(
                            ""
                        )}</select>
                        ${hint}
                    </div>`;
                    }

                    return `<div class="mb-3">
                    <label>${label}</label>
                    <input type="${type}" name="${name}" class="form-control" value="${value}" placeholder="${placeholder}">
                    ${hint}
                </div>`;
                })
                .join("");
        };

        const submitAjax = () => {
            const formData = new FormData(crudForm);
            if (currentMethod !== "POST")
                formData.append("_method", currentMethod);

            fetch(currentUrl, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json"
                },
                body: formData,
            })
                .then(async (res) => {
                    const text = await res.text();
                    try {
                        return JSON.parse(text);
                    } catch {
                        throw new Error("Response bukan JSON");
                    }
                })
                .then((response) => {
                    if (response.success) {
                        Alert.success(response.message);
                    } else {
                        Alert.error(response.message || "Terjadi kesalahan");
                    }
                })
                .catch((err) => Alert.error(err.message));
        };

        const handleCrudClick = (btn) => {
            currentUrl = btn.dataset.url;
            currentMethod = btn.dataset.method || "POST";
            isDeleteAction = btn.dataset.crud === "delete";
            isApproveAction = btn.dataset.crud === "approve";
            isRejectAction = btn.dataset.crud === "reject";

            // ✅ Konfirmasi Approve
            if (isApproveAction) {
                Swal.fire({
                    title: "Konfirmasi Approve",
                    text: "Apakah Anda yakin ingin menyetujui pembayaran ini?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Approve",
                    cancelButtonText: "Batal",
                }).then((res) => res.isConfirmed && submitAjax());
                return;
            }

            // ✅ Konfirmasi Reject
            if (isRejectAction) {
                Swal.fire({
                    title: "Konfirmasi Reject",
                    text: "Apakah Anda yakin ingin menolak pembayaran ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Reject",
                    cancelButtonText: "Batal",
                }).then((res) => res.isConfirmed && submitAjax());
                return;
            }

            // ✅ Konfirmasi Delete
            if (isDeleteAction) {
                Swal.fire({
                    title: "Yakin hapus?",
                    text: "Data ini tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                }).then((res) => res.isConfirmed && submitAjax());
                return;
            }

            // ✅ Form Tambah/Edit
            const fields = JSON.parse(btn.dataset.fields);
            const preset = btn.dataset.values
                ? JSON.parse(btn.dataset.values)
                : {};

            modalTitle.textContent = btn.dataset.title;
            modalBody.innerHTML = buildForm(fields, preset);
            crudSaveBtn.textContent =
                btn.dataset.crud === "add" ? "Tambah" : "Update";
            crudSaveBtn.className =
                btn.dataset.crud === "add"
                    ? "btn btn-primary"
                    : "btn btn-primary";

            modal?.show();
        };

        const bindEvents = () => {
            document
                .querySelectorAll("[data-crud]")
                .forEach((btn) =>
                    btn.addEventListener("click", () => handleCrudClick(btn))
                );
            crudForm?.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!isDeleteAction) submitAjax();
            });
        };

        const init = () => {
            initElements();
            bindEvents();
        };
        return { init };
    })();

    // ==============================
    // 🔹 MODULE: Table Sorting
    // ==============================
    const TableSort = (() => {
        const sortTable = (tableBody, sortOrder) => {
            const rows = Array.from(tableBody.querySelectorAll("tr"));
            rows.sort((a, b) => {
                const nameA = (a.cells[0]?.innerText || "").toUpperCase();
                const nameB = (b.cells[0]?.innerText || "").toUpperCase();
                const nilaiA = parseInt(a.cells[2]?.innerText) || 0;
                const nilaiB = parseInt(b.cells[2]?.innerText) || 0;
                const dateA = new Date(a.cells[5]?.innerText);
                const dateB = new Date(b.cells[5]?.innerText);

                switch (sortOrder) {
                    case "nama_asc":
                        return nameA.localeCompare(nameB);
                    case "nama_desc":
                        return nameB.localeCompare(nameA);
                    case "nilai_asc":
                        return nilaiA - nilaiB;
                    case "nilai_desc":
                        return nilaiB - nilaiA;
                    case "tanggal_asc":
                        return dateA - dateB;
                    case "tanggal_desc":
                        return dateB - dateA;
                    default:
                        return 0;
                }
            });

            tableBody.innerHTML = "";
            rows.forEach((row) => tableBody.appendChild(row));
        };

        const bindEvents = () => {
            document.querySelectorAll("[data-target]").forEach((dropdown) => {
                const tableSelector = dropdown.dataset.target;
                const tableBody = document.querySelector(tableSelector);
                if (!tableBody) return;
                dropdown.addEventListener("change", function () {
                    sortTable(tableBody, this.value);
                });
            });
        };

        const init = () => bindEvents();
        return { init };
    })();

    // ==============================
    // 🔹 MODULE: Flash Alert (Global)
    // ==============================
    const FlashAlert = (() => {
        const init = () => {
            const body = document.body;
            const flashSuccess = body.dataset.success;
            const flashError = body.dataset.error;
            const rawErrors = body.dataset.errors;

            console.log("✅ FlashAlert Debug:");
            console.log("data-success:", flashSuccess);
            console.log("data-error:", flashError);
            console.log("data-errors (raw):", rawErrors);

            let flashErrors = [];
            try {
                flashErrors = JSON.parse(rawErrors || "[]");
            } catch (e) {
                console.error("❌ Gagal parse flashErrors:", e);
            }

            console.log("Parsed flashErrors:", flashErrors);

            if (flashSuccess) Alert.success(flashSuccess);
            if (flashError) Alert.error(flashError);
            if (flashErrors.length > 0) Alert.listWarning(flashErrors);
        };
        return { init };
    })();

    // ==============================
    // 🔹 INIT ALL MODULES
    // ==============================
    CrudModal.init();
    TableSort.init();
    FlashAlert.init();
});

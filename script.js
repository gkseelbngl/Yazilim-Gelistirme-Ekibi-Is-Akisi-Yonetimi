document.addEventListener("DOMContentLoaded", function () {
  // Modal için değişkenler
  const addProjectModal = document.getElementById("addProjectModal");
  const editProjectModal = document.getElementById("editProjectModal");
  const addProjectBtn = document.getElementById("addProjectBtn");
  const closeBtns = document.querySelectorAll(".close");
  const feedback = document.getElementById("feedback");
  const editFeedback = document.getElementById("edit-feedback");
  const loader = document.getElementById("loader");

  // Modal açma
  addProjectBtn.addEventListener("click", function () {
    addProjectModal.style.display = "flex";
  });

  // Modal kapama
  closeBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      addProjectModal.style.display = "none";
      editProjectModal.style.display = "none";
    });
  });

  // Modal dışına tıklama ile kapama
  window.addEventListener("click", function (event) {
    if (event.target == addProjectModal) {
      addProjectModal.style.display = "none";
    }
    if (event.target == editProjectModal) {
      editProjectModal.style.display = "none";
    }
  });

  // Proje ekleme formunu işleyin
  const addProjectForm = document.querySelector("#add-project-form");
  if (addProjectForm) {
    addProjectForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(addProjectForm);
      loader.style.display = "block"; // Yüklenme göstergesini göster
      fetch(addProjectForm.action, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          loader.style.display = "none"; // Yüklenme göstergesini gizle
          feedback.style.display = "block";
          if (data.includes("Error")) {
            feedback.className = "feedback error";
            feedback.innerHTML = "Proje eklenirken bir hata oluştu.";
          } else {
            feedback.className = "feedback success";
            feedback.innerHTML = "Proje başarıyla eklendi.";
            setTimeout(() => {
              window.location.href = "projects.php";
            }, 2000);
          }
        })
        .catch((error) => {
          loader.style.display = "none"; // Yüklenme göstergesini gizle
          feedback.style.display = "block";
          feedback.className = "feedback error";
          feedback.innerHTML = "Proje eklenirken bir hata oluştu.";
          console.error("Error:", error);
        });
    });
  }

  // Proje düzenleme formunu işleyin
  document.querySelectorAll(".edit-project").forEach((button) => {
    button.addEventListener("click", function () {
      const projectId = button.getAttribute("data-id");
      fetch(`edit_project.php?id=${projectId}`)
        .then((response) => response.json())
        .then((data) => {
          if (data.error) {
            alert("Proje bilgisi alınamadı.");
          } else {
            document.getElementById("edit-project-id").value = data.id;
            document.getElementById("edit-name").value = data.name;
            document.getElementById("edit-description").value =
              data.description;
            editProjectModal.style.display = "flex";
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  });

  const editProjectForm = document.querySelector("#edit-project-form");
  if (editProjectForm) {
    editProjectForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(editProjectForm);
      fetch(editProjectForm.action, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          editFeedback.style.display = "block";
          if (data.includes("Error")) {
            editFeedback.className = "feedback error";
            editFeedback.innerHTML = "Proje düzenlenirken bir hata oluştu.";
          } else {
            editFeedback.className = "feedback success";
            editFeedback.innerHTML = "Proje başarıyla güncellendi.";
            setTimeout(() => {
              window.location.href = "projects.php";
            }, 2000);
          }
        })
        .catch((error) => {
          editFeedback.style.display = "block";
          editFeedback.className = "feedback error";
          editFeedback.innerHTML = "Proje düzenlenirken bir hata oluştu.";
          console.error("Error:", error);
        });
    });
  }

  // Proje silme işlemini işleyin
  document.querySelectorAll(".delete-project").forEach((button) => {
    button.addEventListener("click", function () {
      const projectId = button.getAttribute("data-id");
      if (confirm("Bu projeyi silmek istediğinizden emin misiniz?")) {
        fetch(`delete_project.php?id=${projectId}`, {
          method: "GET",
        })
          .then((response) => response.text())
          .then((data) => {
            if (data.includes("Error")) {
              alert("Proje silinirken bir hata oluştu.");
            } else {
              alert("Proje başarıyla silindi.");
              window.location.reload();
            }
          })
          .catch((error) => console.error("Error:", error));
      }
    });
  });

  // Görev ekleme formunu işleyin
  const addTaskForm = document.querySelector("#add-task-form");
  if (addTaskForm) {
    addTaskForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(addTaskForm);
      fetch(addTaskForm.action, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.includes("Error")) {
            alert("Görev eklenirken bir hata oluştu.");
          } else {
            alert("Görev başarıyla eklendi.");
            window.location.href = "tasks.php";
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  }

  // Görev düzenleme formunu işleyin
  const editTaskForm = document.querySelector("#edit-task-form");
  if (editTaskForm) {
    editTaskForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(editTaskForm);
      fetch(editTaskForm.action, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.includes("Error")) {
            alert("Görev düzenlenirken bir hata oluştu.");
          } else {
            alert("Görev başarıyla güncellendi.");
            window.location.href = "tasks.php";
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  }

  // Görev silme işlemini işleyin
  const deleteTaskLinks = document.querySelectorAll(".delete-task");
  deleteTaskLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      if (confirm("Bu görevi silmek istediğinizden emin misiniz?")) {
        fetch(link.href, {
          method: "GET",
        })
          .then((response) => response.text())
          .then((data) => {
            if (data.includes("Error")) {
              alert("Görev silinirken bir hata oluştu.");
            } else {
              alert("Görev başarıyla silindi.");
              window.location.reload();
            }
          })
          .catch((error) => console.error("Error:", error));
      }
    });
  });
});

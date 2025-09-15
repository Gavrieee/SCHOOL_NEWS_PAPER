$(".articleCard").on("dblclick", function (event) {
  var updateArticleForm = $(this).find(".updateArticleForm");
  updateArticleForm.toggleClass("d-none");
});

$(".articleCard").on("dblclick", function (event) {
  var updateArticleForm = $(this).find(".updateArticleForm");
  updateArticleForm.toggleClass("hidden"); // Tailwind way
});

$(document).ready(function () {
  $(".articleCard").on("dblclick", function () {
    $(this).find(".updateArticleForm").toggleClass("hidden");
  });
});

$(".deleteArticleForm").on("submit", function (event) {
  event.preventDefault();
  var formData = {
    article_id: $(this).find(".article_id").val(),
    deleteArticleBtn: 1,
  };
  if (confirm("Are you sure you want to delete this article?")) {
    $.ajax({
      type: "POST",
      url: "core/handleForms.php",
      data: formData,
      success: function (data) {
        if (data) {
          location.reload();
        } else {
          alert("Deletion failed");
        }
      },
    });
  }
});

const input = document.getElementById("photoInput");
const preview = document.getElementById("photoPreview");

input.addEventListener("change", () => {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.src = e.target.result;
      preview.classList.remove("hidden");
    };
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
    preview.classList.add("hidden");
  }
});

// const inputEdit = document.getElementById("photoInputEdit");
// const previewEdit = document.getElementById("photoPreviewEdit");

// input.addEventListener("change", () => {
//   const file = input.files[0];
//   if (file) {
//     const reader = new FileReader();
//     reader.onload = (e) => {
//       preview.src = e.target.result;
//       preview.classList.remove("hidden");
//     };
//     reader.readAsDataURL(file);
//   } else {
//     preview.src = "";
//     preview.classList.add("hidden");
//   }
// });

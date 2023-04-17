const firebaseConfig = {
  apiKey: "AIzaSyBvF0AYtLf9-G7ihonjKMR_XSiPZS5HxG8",
  authDomain: "jwsfurniture-6f0bd.firebaseapp.com",
  projectId: "jwsfurniture-6f0bd",
  storageBucket: "jwsfurniture-6f0bd.appspot.com",
  messagingSenderId: "172095982121",
  appId: "1:172095982121:web:78971b231e37398fafea38"
};

firebase.initializeApp(firebaseConfig);

const googleButton = document.querySelector("#google-login");
const facebookButton = document.querySelector("#facebook-login");


googleButton.addEventListener("click", () => {
  firebase.auth().signOut()
  .then(function() {
    console.log("User signed out successfully");
  })

  const provider = new firebase.auth.GoogleAuthProvider();

  firebase.auth().signInWithPopup(provider)
    .then((result) => {
      const user = result.user;
      $.ajax({
        type: 'post',
        url: 'api/loginGoogle.php',
        data: {
          email: user.email,
          fullname: user.displayName,
          photoURL: user.photoURL,
          uid: user.uid
        },
        success: (response) => {
          if(response == 1){
            alert('Login from Google was successful');
            localStorage.setItem('authenticated', 'true');
            localStorage.setItem('uid', user.uid)
            location.reload();
          }
        }
      })
    })
});

facebookButton.addEventListener("click", () => {
  alert()
  // $.ajax({
  //   type: 'get',
  //   url: 'api/facebook-login.php',
  //   success: (response) => {

  //   }
  // })
  // firebase.auth().signOut()
  // .then(function() {
  //   console.log("User signed out successfully");
  // })

  // const provider = new firebase.auth.FacebookAuthProvider();

  // firebase.auth().signInWithPopup(provider)
  // .then((result) => {
  //   const user = result.user;

  //   $.ajax({
  //     type: 'post',
  //     url: 'api/loginFacebook.php',
  //     data: {
  //       email: user.email,
  //       fullname: user.displayName,
  //       photoURL: user.photoURL,
  //       uid: user.uid
  //     },
  //     success: (response) => {
  //       if(response == 1){
  //         alert('Login from Facebook was successful');
  //         localStorage.setItem('authenticated', 'true');
  //         localStorage.setItem('uid', user.uid)
  //         location.reload();
  //       }
  //     }
  //   })
  // })
});

function signout() {
  localStorage.removeItem('authenticated');
  localStorage.removeItem('uid');
  location.reload();
}
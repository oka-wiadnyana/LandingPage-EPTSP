function beginSpeech() {

    const utterance = new SpeechSynthesisUtterance()
    setTimeout(function(){
        let synth = new SpeechSynthesisUtterance()
        console.log(speechSynthesis.getVoices())
        synth.text = 'Selamat datang di E PTSP Pengadilan Negeri Bangli, bagi penyandang disabilitas dapat menyeleksi text untuk mendengarkan isi konten'
        synth.lang = 'id-ID'
        synth.rate = 1
        speechSynthesis.speak(synth)
    
    },1000)

        let selectedText
        window.addEventListener('mouseup',function () { 

            if (window.getSelection) {
                selectedText = window.getSelection().toString();
                console.log(selectedText)
            } else if (this.document.selection) {
                    selectedText = this.document.selection.createRange().selectedText
                    console.log(selectedText)
                        }

                utterance.text = selectedText
                utterance.rate=1
                utterance.lang='id-ID'
                speechSynthesis.speak(utterance)

                
            })

        window.addEventListener('mouseover',function (e) { 

        //   console.log(e.target.className)
            if(e.target.className=='link') {
                utterance.text = e.target.innerHTML
                utterance.rate=1
                utterance.lang='id-ID'
                speechSynthesis.speak(utterance)
            }
        })

    
}


    

   





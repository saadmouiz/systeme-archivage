<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Accès interdit</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #f43f5e;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e293b, #020617);
            color: var(--light);
            overflow: hidden;
            position: relative;
        }
        
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.5;
        }
        
        .error-container {
            position: relative;
            z-index: 2;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            padding: 40px;
            text-align: center;
            max-width: 550px;
            width: 90%;
            overflow: hidden;
        }
        
        .error-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
            transform: rotate(45deg);
            z-index: -1;
            animation: shimmer 6s linear infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-150%) rotate(45deg); }
            100% { transform: translateX(150%) rotate(45deg); }
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 10px;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .lock-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            opacity: 0;
        }
        
        .lock-body {
            width: 60px;
            height: 45px;
            background: var(--secondary);
            border-radius: 8px;
            position: absolute;
            bottom: 0;
            left: 10px;
        }
        
        .lock-shackle {
            width: 30px;
            height: 30px;
            border: 8px solid var(--secondary);
            border-bottom: none;
            border-radius: 30px 30px 0 0;
            position: absolute;
            top: 5px;
            left: 25px;
        }
        
        h1 {
            margin-bottom: 15px;
            font-size: 32px;
            background: linear-gradient(to right, var(--light), #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(20px);
        }
        
        p {
            margin-bottom: 30px;
            color: var(--gray);
            font-size: 18px;
            line-height: 1.7;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }
        
        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
        }
        
        .button:hover::before {
            left: 100%;
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>
    
    <div class="error-container">
        <div class="error-code" id="error-code">403</div>
        <div class="lock-container" id="lock">
            <div class="lock-shackle" id="lock-shackle"></div>
            <div class="lock-body"></div>
        </div>
        <h1 id="title">Accès Verrouillé</h1>
        <p id="message">Vous avez tenté d'accéder à une zone sécurisée. Malheureusement, vous ne disposez pas des autorisations nécessaires pour voir cette page.</p>
        <a href="{{ route('dashboard') }}" class="button" id="button">Retourner en zone sûre</a>
    </div>

    <script>
        // Création des particules
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Positionner aléatoirement
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const size = Math.random() * 4 + 2;
            const opacity = Math.random() * 0.6 + 0.2;
            
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.opacity = opacity;
            
            particlesContainer.appendChild(particle);
            
            // Animation des particules
            gsap.to(particle, {
                x: (Math.random() - 0.5) * 200,
                y: (Math.random() - 0.5) * 200,
                duration: Math.random() * 20 + 10,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }
        
        // Animation du cadenas
        gsap.to("#lock", {
            opacity: 1,
            duration: 1,
            delay: 0.2
        });
        
        gsap.fromTo("#lock-shackle", 
            { y: -20 },
            { y: 0, duration: 0.6, delay: 0.8, ease: "bounce.out" }
        );
        
        // Animation du texte et du bouton
        const timeline = gsap.timeline({ delay: 0.5 });
        
        timeline.to("#error-code", {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "back.out(1.7)"
        })
        .to("#title", {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.2")
        .to("#message", {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.3")
        .to("#button", {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.3");
    </script>
</body>
</html><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Accès interdit</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #f43f5e;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e293b, #020617);
            color: var(--light);
            overflow: hidden;
            position: relative;
        }
        
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.5;
        }
        
        .error-container {
            position: relative;
            z-index: 2;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            padding: 40px;
            text-align: center;
            max-width: 550px;
            width: 90%;
            overflow: hidden;
        }
        
        .error-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
            transform: rotate(45deg);
            z-index: -1;
            animation: shimmer 6s linear infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-150%) rotate(45deg); }
            100% { transform: translateX(150%) rotate(45deg); }
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 10px;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .lock-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            opacity: 0;
        }
        
        .lock-body {
            width: 60px;
            height: 45px;
            background: var(--secondary);
            border-radius: 8px;
            position: absolute;
            bottom: 0;
            left: 10px;
        }
        
        .lock-shackle {
            width: 30px;
            height: 30px;
            border: 8px solid var(--secondary);
            border-bottom: none;
            border-radius: 30px 30px 0 0;
            position: absolute;
            top: 5px;
            left: 25px;
        }
        
        h1 {
            margin-bottom: 15px;
            font-size: 32px;
            background: linear-gradient(to right, var(--light), #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(20px);
        }
        
        p {
            margin-bottom: 30px;
            color: var(--gray);
            font-size: 18px;
            line-height: 1.7;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        }
        
        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
        }
        
        .button:hover::before {
            left: 100%;
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>
    
    <div class="error-container">
        <div class="error-code" id="error-code">403</div>
        <div class="lock-container" id="lock">
            <div class="lock-shackle" id="lock-shackle"></div>
            <div class="lock-body"></div>
        </div>
        <h1 id="title">Accès Verrouillé</h1>
        <p id="message">Vous avez tenté d'accéder à une zone sécurisée. Malheureusement, vous ne disposez pas des autorisations nécessaires pour voir cette page.</p>
        <a href="{{ route('dashboard') }}" class="button" id="button">Retourner en zone sûre</a>
    </div>

    <script>
        // Création des particules
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Positionner aléatoirement
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            const size = Math.random() * 4 + 2;
            const opacity = Math.random() * 0.6 + 0.2;
            
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.opacity = opacity;
            
            particlesContainer.appendChild(particle);
            
            // Animation des particules
            gsap.to(particle, {
                x: (Math.random() - 0.5) * 200,
                y: (Math.random() - 0.5) * 200,
                duration: Math.random() * 20 + 10,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        }
        
        // Animation du cadenas
        gsap.to("#lock", {
            opacity: 1,
            duration: 1,
            delay: 0.2
        });
        
        gsap.fromTo("#lock-shackle", 
            { y: -20 },
            { y: 0, duration: 0.6, delay: 0.8, ease: "bounce.out" }
        );
        
        // Animation du texte et du bouton
        const timeline = gsap.timeline({ delay: 0.5 });
        
        timeline.to("#error-code", {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "back.out(1.7)"
        })
        .to("#title", {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.2")
        .to("#message", {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.3")
        .to("#button", {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.3");
    </script>
</body>
</html>
from fastapi import FastAPI, File, UploadFile
from deepface import DeepFace
import shutil
import os

from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.post("/verify")
async def verify_img(img1: UploadFile = File(...), img2: UploadFile = File(...)):
    path1 = f"temp_{img1.filename}"
    path2 = f"temp_{img2.filename}"
    try:
        with open(path1, "wb") as buffer:
            shutil.copyfileobj(img1.file, buffer)
        with open(path2, "wb") as buffer:
            shutil.copyfileobj(img2.file, buffer)
        
        result = DeepFace.verify(
            img1_path=path1,
            img2_path=path2,
            model_name='Facenet',
            detector_backend='opencv',
            enforce_detection=True
        )
        return {
            "verified": bool(result["verified"]),
            "distance": float(result["distance"]),
            "model": result["model"]
        }
    except Exception as e:
        return {"error": str(e)}
    finally:
        if os.path.exists(path1):
            os.remove(path1)
        if os.path.exists(path2):
            os.remove(path2)

@app.post("/analyze")
async def analyze_img(img: UploadFile = File(...)):
    path = f"temp_{img.filename}"
    try:
        with open(path, "wb") as buffer:
            shutil.copyfileobj(img.file, buffer)
        
        result = DeepFace.analyze(
            img_path=path,
            actions=['emotion'],
            enforce_detection=True,
            detector_backend='opencv'
        )
        
        if isinstance(result, list):
            result = result[0]
            
        return {
            "dominant_emotion": result["dominant_emotion"],
            "emotion_scores": result["emotion"]
        }
    except Exception as e:
        return {"error": str(e)}
    finally:
        if os.path.exists(path):
            os.remove(path)

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=5000)

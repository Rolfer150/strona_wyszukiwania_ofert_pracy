from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from transformers import pipeline, AutoTokenizer, AutoModelForSeq2SeqLM
import re

app = FastAPI()

# CORS dla frontendowej aplikacji
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Inicjalizacja modelu
try:
    tokenizer = AutoTokenizer.from_pretrained("google/flan-t5-large")
    model = AutoModelForSeq2SeqLM.from_pretrained("google/flan-t5-large")
    generator = pipeline("text2text-generation", model=model, tokenizer=tokenizer)
except Exception as e:
    print("Błąd ładowania modelu:", e)
    generator = None

# Dane wejściowe
class HelperMaterialRequest(BaseModel):
    offer_title: str
    tasks: list[str]
    expectancies: list[str]

@app.get("/")
def home():
    return {"message": "API do generowania materiałów pomocniczych działa."}

@app.post("/generate_materials")
def generate_materials(data: HelperMaterialRequest):
    if not generator:
        return {"materials": ["Model ML nie został poprawnie załadowany."]}

    prompt = (
        f"Job title: {data.offer_title}\n"
        f"Tasks: {', '.join(data.tasks)}\n"
        f"Requirements: {', '.join(data.expectancies)}\n\n"
        f"Generate a concise step-by-step training guide (3-5 steps) "
        f"for a new employee starting as a {data.offer_title}. "
        f"The guide should include practical instructions based on tasks and requirements. "
        f"Each step must begin with a hyphen (-).\n"
        f"Example:\n"
        f"- Familiarize yourself with safety procedures in the work environment.\n"
        f"- Learn how to operate the primary tools used on site.\n"
        f"- Understand daily reporting procedures.\n"
        f"Now generate the steps:"
    )

    try:
        result = generator(prompt, max_new_tokens=200, num_return_sequences=1, do_sample=False)
        print("PROMPT:", prompt)
        print("RESULT:", result)
        text = result[0].get('generated_text', '')
        materials = re.findall(r"- .*?(?=\n|$)", text)
        materials = [m.strip() for m in materials if len(m.strip()) > 10]
        if not materials:
            materials = ["Nie udało się wygenerować materiałów."]
    except Exception as e:
        materials = [f"Błąd generowania: {str(e)}"]

    return {"materials": materials}
